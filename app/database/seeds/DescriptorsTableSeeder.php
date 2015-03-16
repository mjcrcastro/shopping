<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DescriptorsTableSeeder extends Seeder {
    public function run () {
        DB::table('descriptors')->insert(array(
           array('id'=>1,'descriptor_id'=>'0','description'=>"Generic Name",),
           array('id'=>2,'descriptor_id'=>'0','description'=>"Marca",),
           array('id'=>3,'descriptor_id'=>'0','description'=>"Empaque",),
           array('id'=>4,'descriptor_id'=>'0','description'=>"Peso",), 
           
           array('id'=>5,'descriptor_id'=>'1','description'=>"Salsa de Tomate",),
           array('id'=>6,'descriptor_id'=>'3','description'=>"Naturas",),
           array('id'=>7,'descriptor_id'=>'0','description'=>"Bolsa",), 
           array('id'=>8,'descriptor_id'=>'0','description'=>"220 gr",),  
        ));
    }
}