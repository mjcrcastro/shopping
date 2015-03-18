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
		//
            Schema::create('purchases',function($table){
                $table->increments('id');
                $table->integer('shop_id')
                           ->index()->references('id')->on('shops');
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
		//
            Schema::drop('purchases');
	}

}
