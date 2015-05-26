<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShoppingListProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shopping_lists_products', function($table) {
                   $table->increments('id');
                   $table->integer('shopping_list_id')
                           ->index()->references('id')->on('shopping_lists');
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
		//
            Schema::drop('shopping_lists_products)');
	}

}
