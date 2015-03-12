<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
                   Schema::create('roles_actions', function($table) {
                   $table->increments('id');
                   $table->integer('action_id')->index()->references('id')->on('actions');
                   $table->integer('role_id')->index()->references('id')->on('roles');
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
            Schema::drop('roles_actions');
	}

}
