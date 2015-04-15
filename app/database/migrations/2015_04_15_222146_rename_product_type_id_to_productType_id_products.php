<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameProductTypeIdToProductTypeIdProducts extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //forgot to name the field properly
        Schema::table('products', function($table) {
            $table->renameColumn('product_type_id', 'productType_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('products', function($table) {
            $table->renameColumn('productType_id', 'product_type_id');
        });
    }

}
