<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Helper {

    public static function usercan($action_code, $user) {
        /*
         * Will check for all the actions assigned to the role the user
         * has been assigned to. In case there is at leas one 
         * permission that corresponds to the action_code, the user
         * has been granted permissions, otherwise the answer is false
         */
        $actions_allowed = $user->role->actions()->where('code', '=', $action_code)->get();

        return count($actions_allowed) ? 0 : 'Access denied to action : ' . Helper::actionDescription($action_code);
        
    }

    public static function actionDescription($action_code) {
           //returns description of $action_code
        $actions_collection = Action::where('code', '=', $action_code)->get();

        foreach ($actions_collection as $action_record) {
            return $action_record->description;
        }
    }

    public static function lastQuery() {
        //returns last executed query
        $queries = DB::getQueryLog();
        $last_query = end($queries);

        return $last_query;
    }
    
    
    
}
