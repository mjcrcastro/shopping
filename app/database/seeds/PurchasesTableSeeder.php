<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PurchasesTableSeeder extends Seeder {
    public function run () {
        DB::table('purchases')->insert(array(
           array('id'=>1,'shop_id'=>'1','purchase_date'=>'2015-03-12','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
        ));
    }
}