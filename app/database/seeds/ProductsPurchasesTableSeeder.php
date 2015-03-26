<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductsPurchasesTableSeeder extends Seeder {
    public function run () {
        DB::table('products_purchases')->insert(array(
           array('id'=>1,
               'purchase_id'=>1,
               'product_id'=>1,
               'amount'=>1,
               'total'=>'48',),
           array('id'=>2,
               'purchase_id'=>1,
               'product_id'=>2,
               'amount'=>12,
               'total'=>'120',), 
        ));
    }
}