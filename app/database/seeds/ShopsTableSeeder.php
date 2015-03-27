<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ShopsTableSeeder extends Seeder {
    public function run () {
        DB::table('shops')->insert(array(
           array('id'=>1,'description'=>"La Colonia Linda Vista",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
        ));
    }
}