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

            DB::setFetchMode(PDO::FETCH_ASSOC);
            $result = DB::table($tableName)->get(); // array of arrays instead of objects
            DB::setFetchMode(PDO::FETCH_CLASS);

            $fields = Schema::getColumnListing($tableName);

            $filename = $tableName . ".csv";
            $handle = fopen($filename, 'w+');

            fputcsv($handle, $fields);

            foreach ($result as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }

        //now zip the files
        $zipFile = "backup.zip";
        
        $zipArchive = new ZipArchive($zipFile, ZIPARCHIVE::OVERWRITE);

        if (!$zipArchive) {
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
