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
                   $table->string('description');
                   //id of parent descriptor
                   $table->integer('descriptor_id')->default(0)
                           //this is a selfrerencing table
                           //parents are categories, childs are values
                           ->index()->references('id')->on('descriptors');
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
