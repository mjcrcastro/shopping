<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RolesActionsTableSeeder extends Seeder {
    public function run () {
        DB::table('roles_actions')->insert(array(
           array('id'=>1, 
               'role_id'=>'1',
               'action_id'=>'1',),
            array('id'=>2, 
               'role_id'=>'1',
               'action_id'=>'2',),
            array('id'=>3, 
               'role_id'=>'1',
               'action_id'=>'3',),
            array('id'=>4, 
               'role_id'=>'1',
               'action_id'=>'4',),
            array('id'=>5 ,
               'role_id'=>'1',
               'action_id'=>'5',),
            array('id'=>6, 
               'role_id'=>'1',
               'action_id'=>'6',),
            array('id'=>7, 
               'role_id'=>'1',
               'action_id'=>'7',),
            array('id'=>8, 
               'role_id'=>'1',
               'action_id'=>'8',),
            array('id'=>9, 
               'role_id'=>'1',
               'action_id'=>'9',),
            array('id'=>10, 
               'role_id'=>'1',
               'action_id'=>'10',),
            array('id'=>11, 
               'role_id'=>'1',
               'action_id'=>'11',),
            array('id'=>12, 
               'role_id'=>'1',
               'action_id'=>'12',),
            array('id'=>13, 
               'role_id'=>'1',
               'action_id'=>'13',),
            array('id'=>14, 
               'role_id'=>'1',
               'action_id'=>'14',),
            array('id'=>15, 
               'role_id'=>'1',
               'action_id'=>'15',),
            array('id'=>16, 
               'role_id'=>'1',
               'action_id'=>'16',),
            array('id'=>17, 
               'role_id'=>'1',
               'action_id'=>'17',),
            array('id'=>18, 
               'role_id'=>'1',
               'action_id'=>'18',),
        ));
    }
}