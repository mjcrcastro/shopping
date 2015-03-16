<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DescriptorsTypesTableSeeder extends Seeder {
    public function run () {
        DB::table('descriptors_types')->insert(array(
           array('id'=>1,'description'=>"Generic Name",),
           array('id'=>2,'description'=>"Marca",),
           array('id'=>3,'description'=>"Empaque",),
           array('id'=>4,'description'=>"Peso",), 
        ));
    }
}