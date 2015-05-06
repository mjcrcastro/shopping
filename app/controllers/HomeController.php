<?php

class HomeController extends \BaseController {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
     */

    public function showDashboard() {

        //first the list of companies

        $action_code = 'home_dashboard';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }

        $data = [];

        $raw_data = DB::table('products_purchases')
                ->select(DB::raw('products_types.description, sum(products_purchases.total) as total'))
                ->join('products', 'products.id', '=', 'products_purchases.product_id')
                ->join('products_types', 'products_types.id', '=', 'products.product_type_id')
                ->join('purchases', 'products_purchases.purchase_id', '=', 'purchases.id')
                ->groupBy('products_types.id')
                ->groupBy('purchases.user')
                ->having('user', '=', Auth::user()->username)
                ->get();

        foreach ($raw_data as $row) {
            $data[] = [
                $row->description,
                floatval($row->total)
            ];
        }



        return View::make('home.dashboard', compact('data'));
    }
    
    public function createShoppingList() {

        //first the list of companies

        $action_code = 'home_shopping_list';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) { return Redirect::back()->with('message', $message);}
        //a return won't let the following code to continue
       
        return View::make('home.shoppinglist');
    }

    public function getData() {

        $allTableNames = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableNames();
        
        $this->exportToCsv($allTableNames);
        
        $zipFile = $this->zipCsvFiles();

        //now delete the *.csv files
        foreach (glob("*.csv") as $filename) {
            unlink($filename);
        }

        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );

        return Response::download($zipFile, $zipFile, $headers);
    }

    private function zipCsvFiles() {
        //now zip the files
        $zipFile = "shopping" . date('Ymd Hi') . ".zip";

        $zipArchive = new ZipArchive();

        if ($zipArchive->open($zipFile, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
            die("Failed to create archive\n");
        }

        $zipArchive->addGlob("*.csv");
        if (!$zipArchive->status == ZIPARCHIVE::ER_OK) {
            echo "Failed to write files to zip\n";
        }

        $zipArchive->close();
        
        return $zipFile;
    }
    
    private function exportToCsv($allTableNames) {
        
        foreach ($allTableNames as $name) {

            $fields = Schema::getColumnListing($name);

            $result = DB::table($name)->get();

            $handle = fopen($name . ".csv", 'w+');

            fputcsv($handle, $fields);

            foreach ($result as $row) {
                fputcsv($handle, (array) $row);  //fputcsv requires array
                // as second parameter
            }

            fclose($handle);
        }
        
    }
}
