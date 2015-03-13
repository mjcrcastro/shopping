<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionsTableSeeder extends Seeder {
    public function run () {
        DB::table('actions')->insert(array(
           array('id'=>1, 
               'description'=>'Add users','code'=>'users_add'),
           array('id'=>2, 
               'description'=>'Edit users','code'=>'users_edit'),
           array('id'=>3, 
               'description'=>'Delete users','code'=>'users_delete'),  
           array('id'=>4, 
               'description'=>'Update users','code'=>'users_update'),
           array('id'=>5, 
               'description'=>'Save created user','code'=>'users_store'),
           array('id'=>6, 
               'description'=>'List users','code'=>'users_index'),  
           array('id'=>7, 
               'description'=>'Add role','code'=>'roles_add'),   
           array('id'=>8, 
               'description'=>'Edit role','code'=>'roles_edit'),   
           array('id'=>9, 
               'description'=>'Delete role','code'=>'roles_delete'),    
           array('id'=>10, 
               'description'=>'Update role','code'=>'roles_update'),    
           array('id'=>11, 
               'description'=>'List roles','code'=>'roles_index'),     
           array('id'=>12, 
               'description'=>'Update role','code'=>'roles_permissions_edit'), 
           array('id'=>13, 
               'description'=>'Update role','code'=>'roles_permissions_update'),
           array('id'=>14, 
               'description'=>'Add shop','code'=>'shops_add'),   
           array('id'=>15, 
               'description'=>'Edit shop','code'=>'shops_edit'),   
           array('id'=>16, 
               'description'=>'Delete shop','code'=>'shops_delete'),    
           array('id'=>17, 
               'description'=>'Update shop','code'=>'shops_update'),    
           array('id'=>18, 
               'description'=>'Update shop','code'=>'shops_store'),  
           array('id'=>19, 
               'description'=>'List shops','code'=>'shops_index'), 
        ));
    }
}