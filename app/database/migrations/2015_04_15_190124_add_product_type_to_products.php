<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductTypeToProducts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//add column remember token
            Schema::table('products',function($table){
                  $table->integer('product_type_id')
                          ->index()->references('id')->on('products_types');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('products', function($table) {
                $table->dropColumn('product_type_id');
        });
	}

}
