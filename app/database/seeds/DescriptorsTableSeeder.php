<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DescriptorsTableSeeder extends Seeder {
    public function run () {
        DB::table('descriptors')->insert(array(
           array('id'=>1,'descriptorType_id'=>1,'description'=>"Salsa de Tomate",),
           array('id'=>2,'descriptorType_id'=>2,'description'=>"Naturas",),
           array('id'=>3,'descriptorType_id'=>3,'description'=>"Bolsa",), 
           array('id'=>4,'descriptorType_id'=>4,'description'=>"220 gr",),  
        ));
    }
}