<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferenceMarkPurchaseTable extends Migration {

	public function up()
	{
		//add column remember token
            Schema::table('purchases',function($table){
                  $table->boolean('is_reference')
                          ->default(false);
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchases', function($table) {
                $table->dropColumn('is_reference');
        });
	}

}
