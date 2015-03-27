<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductsDescriptorsTableSeeder extends Seeder {
    public function run () {
        DB::table('products_descriptors')->insert(array(
            array('id'=>1,
                'product_id'=>'1',
                'descriptor_id'=>'1','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
            array('id'=>2,
                'product_id'=>'1',
                'descriptor_id'=>'2','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
            array('id'=>3,
                'product_id'=>'1',
                'descriptor_id'=>'3','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
            array('id'=>4,
                'product_id'=>'1',
                'descriptor_id'=>'4','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
            array('id'=>5,
                'product_id'=>'99',
                'descriptor_id'=>'5','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
            array('id'=>6,
                'product_id'=>'99',
                'descriptor_id'=>'6','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
            array('id'=>7,
                'product_id'=>'99',
                'descriptor_id'=>'7','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
            array('id'=>8,
                'product_id'=>'99',
                'descriptor_id'=>'8','created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
        ));
    }
}