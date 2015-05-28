<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVerifiedMarkProductPurchase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    //was_verified indicates that the reported price
            //was actually verified
            Schema::table('products_purchases',function($table){
                  $table->datetime('verified_date')
                          ->nullable()
                          ->default(null);
                  $table->integer('verified_by_id')
                          ->index()
                          ->nullable()
                          ->references('id')
                          ->on('users')
                          ->default(null);
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
            Schema::table('products_purchases', function($table) {
                $table->dropColumn('verified_date');
                $table->dropColumn('verified_by_id');
        });
	}

}
