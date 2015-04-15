<?php

class HomeController extends \BaseController {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
     */

    public function showDashboard() {

        //first the list of companies

        return View::make('home.dashboard', compact('series', 'categories'));
    }

    public function getData() {
        $allTables = DB::select('SHOW TABLES');

        foreach ($allTables as $table) {
            
            $tableName = $table->Tables_in_lar_shopping;
            
            $result = DB::table($tableName)->get();
            
            if ($result) {
                return $result;
            }
            
            $fields =  Schema::getColumnListing($tableName);
            $filename = $tableName.".csv";
            $handle = fopen($filename, 'w+');

            fputcsv($handle, $fields);

            foreach ($result as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);

            $headers = array(
                'Content-Type' => 'text/csv',
            );

            //return Response::download($filename, $filename, $headers);
        }
    }

}
