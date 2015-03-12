<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// $this->call('UserTableSeeder');
                $this->call('UsersTableSeeder');
                $this->call('ActionsTableSeeder');
                $this->call('RolesTableSeeder');
                $this->call('RolesActionsTableSeeder');
                $this->call('ProductsTableSeeder');
                $this->call('ShopsTableSeeder');
	}

}
