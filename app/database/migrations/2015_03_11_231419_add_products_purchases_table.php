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
                   $table->integer('purchase_id')
                           ->index()->references('id')->on('purchases');
                   $table->integer('product_id')
                           ->index()->references('id')->on('products');
                   $table->decimal('amount',8,2);
                   $table->decimal('total',8,2);
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
