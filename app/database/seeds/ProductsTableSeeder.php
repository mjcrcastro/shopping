<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductsTableSeeder extends Seeder {
    public function run () {
        DB::table('products')->insert(array(
           array('id'=>1, 
               'generic_id'=>"1",
               'brand_id'=>"1",
               'style_id'=>"1",
               'package_id'=>"1",
               'size_id'=>"1",
               'color_id'=>"1",
               'flavor_id'=>"1",),
        ));
    }
}