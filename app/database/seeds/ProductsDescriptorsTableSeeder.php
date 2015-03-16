<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProductsDescriptorsTableSeeder extends Seeder {
    public function run () {
        DB::table('roles_actions')->insert(array(
            array('id'=>1,
                'product_id'=>'1',
                'descriptor_id'=>'1',),
            array('id'=>2,
                'product_id'=>'1',
                'descriptor_id'=>'2',),
            array('id'=>3,
                'product_id'=>'1',
                'descriptor_id'=>'3',),
            array('id'=>4,
                'product_id'=>'1',
                'descriptor_id'=>'4',),
        ));
    }
}