<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add products table
            
                 Schema::create('purchases', function($table) {
                   $table->increments('id');
                   $table->integer('product_id')
                           ->index()->references('id')->on('products');
                   $table->integer('shop_id')
                           ->index()->references('id')->on('shops');
                   $table->float('amount');
                   $table->float('total');
                   $table->datetime('purchase_date');
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
            Schema::drop('purchases');
	}

}
