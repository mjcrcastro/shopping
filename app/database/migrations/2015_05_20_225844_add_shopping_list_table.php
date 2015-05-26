<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShoppingListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
            Schema::create('shopping_lists',function($table ) {
                $table->increments('id');
                $table->string('note'); //to annotate observations
                $table->date('planned_date');
                $table->integer('shop_id');
                $table->string('user');
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
            Schema::drop('shopping_lists');
	}

}
