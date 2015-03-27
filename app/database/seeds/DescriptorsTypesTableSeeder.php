<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DescriptorsTypesTableSeeder extends Seeder {
    public function run () {
        DB::table('descriptors_types')->insert(array(
           array('id'=>1,'description'=>"Generic Name",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>2,'description'=>"Marca",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>3,'description'=>"Empaque",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",),
           array('id'=>4,'description'=>"Peso",'created_at'=>"2015-03-23",
               'updated_at'=>"2015-03-23",), 
        ));
    }
}