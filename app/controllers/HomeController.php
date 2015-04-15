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

        $total = DB::table('products_purchases')
                ->join('products', 'products.id', '=', 'products_purchases.product_id')
                ->join('products_types', 'products_types.id', '=', 'products.producttype_id')
                ->join('purchases', 'products_purchases.purchase_id', '=', 'purchases.id')
                ->groupBy('purchases.user')
                ->having('user', '=', Auth::user()->username)
                ->count();
        if ($total === 0) {
            $series = [0, 0];
        } else {

            $series = DB::table('products_purchases')
                    ->select('products_types.description', 'product_purchases.total /' . $total)
                    ->join('products', 'products.id', '=', 'products_purchases.product_id')
                    ->join('products_types', 'products_types.id', '=', 'products.productType_id')
                    ->join('purchases', 'products_purchases.purchase_id', '=', 'purchases.id')
                    ->groupBy('purchases.user')
                    ->having('user', '=', Auth::user()->username);
        }
        
        return $series;
        
        return View::make('home.dashboard', compact('series'));
    }

    public function getData() {

        if (Config::get('database.default') === 'mysql') {
            $allTables = DB::select('SHOW TABLES');
        } else {
            $allTables = DB::select("SELECT * FROM pg_catalog.pg_tables WHERE schemaname != 'pg_catalog' AND schemaname != 'information_schema'");
        }

        foreach ($allTables as $table) {

            if (Config::get('database.default') === 'mysql') {
                $tableName = $table->Tables_in_lar_shopping;
            } else {
                $tableName = $table->tablename;
            }

            $fields = Schema::getColumnListing($tableName);

            $result = DB::table($tableName)->get();

            $filename = $tableName . ".csv";
            $handle = fopen($filename, 'w+');

            fputcsv($handle, $fields);

            foreach ($result as $row) {
                fputcsv($handle, (array) $row);  //fputcsv requires array
                // as second parameter
            }

            fclose($handle);
        }

        //now zip the files
        $zipFile = "backup.zip";

        $zipArchive = new ZipArchive();

        if ($zipArchive->open($zipFile, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
            die("Failed to create archive\n");
        }

        $zipArchive->addGlob("*.csv");
        if (!$zipArchive->status == ZIPARCHIVE::ER_OK) {
            echo "Failed to write files to zip\n";
        }

        $zipArchive->close();

        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );

        return Response::download($zipFile, $zipFile, $headers);
    }

}
