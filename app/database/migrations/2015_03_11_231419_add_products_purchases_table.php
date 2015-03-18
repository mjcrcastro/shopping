<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductsPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add products table
            
                 Schema::create('products_purchases', function($table) {
                   $table->increments('id');
                   $table->integer('product_id')
                           ->index()->references('id')->on('products');
                   $table->float('amount');
                   $table->float('total');
                   $table->timestamps();
               });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Drop table products
            Schema::drop('products_purchases');
	}

}
