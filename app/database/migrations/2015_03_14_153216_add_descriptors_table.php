<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add descriptors table
            
                 Schema::create('descriptors', function($table) {
                   $table->increments('id');
                   $table->integer('descriptor_id')->index()->references('id')->on('descriptors');
                   $table->integer('category_id')->index()->references('id')->on('categories');
                   $table->string('description');
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
            Schema::drop('descriptors');
	}

}
