<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SeqUpdate extends Seeder {

    public function run() {
        if (DB::connection()->getName() == 'pgsql') {
            $this->command->info('updating tables seeds ');
            DB::select("SELECT  setval('actions_id_seq', (select max(id)  from actions));");
            DB::select("SELECT  setval('descriptors_id_seq', (select max(id)  from descriptors));");
            DB::select("SELECT  setval('descriptors_types_id_seq', (select max(id)  from descriptors_types));");
            DB::select("SELECT  setval('products_descriptors_id_seq', (select max(id)  from products_descriptors));");
            DB::select("SELECT  setval('products_id_seq', (select max(id)  from products));");
            DB::select("SELECT  setval('products_purchases_id_seq', (select max(id)  from products_purchases));");
            DB::select("SELECT  setval('products_types_id_seq', (select max(id)  from products_types));");
            DB::select("SELECT  setval('purchases_id_seq', (select max(id)  from purchases));");
            DB::select("SELECT  setval('roles_actions_id_seq', (select max(id)  from roles_actions));");
            DB::select("SELECT  setval('roles_id_seq', (select max(id)  from roles));");
            DB::select("SELECT  setval('shops_id_seq', (select max(id)  from shops));");
            DB::select("SELECT  setval('users_id_seq', (select max(id)  from users));");
            $this->command->info('done ... ');
        }
    }

}
