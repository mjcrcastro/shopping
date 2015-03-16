<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductsTableSeeder extends Seeder {
    public function run () {
        DB::table('products')->insert(array(
           array('id'=>1,),
           array('id'=>2,),
           array('id'=>3,),
           array('id'=>4,),
           array('id'=>5,),
           array('id'=>6,), 
        ));
    }
}