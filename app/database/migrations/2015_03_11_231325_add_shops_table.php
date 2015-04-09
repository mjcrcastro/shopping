<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Add product codes
            //Add products table
            
                 Schema::create('shops', function($table) {
                   $table->increments('id');
                   $table->string('description');
                   $table->string('locationAddress');
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
		//Drop table product codes
                Schema::drop('shops');
	}

}
