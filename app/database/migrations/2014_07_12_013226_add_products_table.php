<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add products table
            
                 Schema::create('products', function($table) {
                   $table->increments('id');
                   $table->integer('generic_id')->index()->references('id')->on('generics');
                   $table->integer('brand_id')->index()->references('id')->on('brands');
                   $table->integer('style_id')->index()->references('id')->on('styles');
                   $table->integer('package_id')->index()->references('id')->on('packages');
                   $table->integer('size_id')->index()->references('id')->on('sizes');
                   $table->integer('color_id')->index()->references('id')->on('colors');
                   $table->integer('flavor_id')->index()->references('id')->on('flavors');
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
            Schema::drop('products');
	}

}
