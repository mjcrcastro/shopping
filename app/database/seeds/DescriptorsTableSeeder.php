<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DescriptorsTableSeeder extends Seeder {
    public function run () {
        DB::table('descriptors')->insert(array(
           array('id'=>1,'descriptorType_id'=>1,'description'=>"Salsa de Tomate",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>2,'descriptorType_id'=>2,'description'=>"Naturas",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>3,'descriptorType_id'=>3,'description'=>"Bolsa",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",), 
           array('id'=>4,'descriptorType_id'=>4,'description'=>"220 gr",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>5,'descriptorType_id'=>1,'description'=>"Leche de Sabor",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>6,'descriptorType_id'=>2,'description'=>"Centrolac",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>7,'descriptorType_id'=>3,'description'=>"Caja",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",), 
           array('id'=>8,'descriptorType_id'=>4,'description'=>"250 ml",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),   
        ));
    }
}