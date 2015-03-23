<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsersTableSeeder extends Seeder {
    public function run () {
        DB::table('users')->insert(array(
           array('id'=>1, 
               'username'=>"admin",
               'name'=>"Manuel Castro",
               'role_id'=>'1',
               'email'=>"mjcrcastro@hotmail.com",
               'password'=>Hash::make('1h1hpcha'),
               'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",
                ),
               
        ));
    }
}