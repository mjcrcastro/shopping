<?php

class PermissionsController extends \BaseController {

    public function edit($id) {
        //Redirects to permissions edition for a given role ($id)

        $action_code = 'roles_permissions_edit';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $permissions = DB::table('actions')
                    ->select('actions.id as action_id', 'actions.description', 'role_id')
                    ->leftjoin(DB::raw(
                                    '(SELECT role_id, action_id FROM roles_actions where role_id = ' . $id . ') filtered_permissions'), function($join) {
                        $join->on('actions.id', '=', 'filtered_permissions.action_id');
                    })
                    ->get();

            /*      For testing purposes only
              $queries = DB::getQueryLog();
              $last_query = end($queries);

              return($last_query);

             */
            //provide the view with the name of the role
            $role_name = Role::find($id)->description;

            if (is_null($permissions)) {
                return Redirect::route('actions.index');
            }
            return View::make('permissions.edit', compact('permissions', 'id', 'role_name'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $action_code = 'roles_permissions_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Receives and updates new company data
            $input = Input::get('actions');

            //delete all records from the current role_id from table roles_actions

            DB::table('roles_actions')->where('role_id', '=', $id)->delete();

            //now insert all 
            //first run over all the array to add the role_id

            foreach ($input as &$row) {
                $data[] = array('role_id' => $id, 'action_id' => $row);
            }

            Permission::insert($data);

            return Redirect::route('roles.index');
        }
    }

}
