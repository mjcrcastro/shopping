<?php

class UsersController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $action_code = 'users_index';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Displays the list of users
            $users = User::all();

            return View::make('users.index', compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $action_code = 'users_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //For adding new users

            return View::make('users.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $action_code = 'users_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Save new user data
            $input = Input::all();

            $validation = Validator::make($input, User::$rules);

            if ($validation->passes()) {

                $user = new User;

                $user->username = Input::get('username');
                $user->name = Input::get('name');
                $user->email = Input::get('email');
                $user->password = Hash::make(Input::get('password'));
                $user->save();

                return Redirect::route('users.index');
            }
            return Redirect::route('users.create')
                            ->withInput()
                            ->withErrors($validation)
                            ->with('message', 'There were validation errors');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $action_code = 'users_edit';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Redirect to edit users form
            $user = User::find($id);
            if (is_null($user)) {
                return Redirect::route('users.index');
            }
            $roles = Role::lists('description','id');
            return View::make('users.edit', compact('user','roles'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $action_code = 'users_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Receive data to be updated and update it
            $input = Input::all();
            //This made only because when updating a user with the same username will faile.
            $rules = array(
                'username' => 'sometimes|required|min:8|unique:users',
                'password' => 'confirmed',
                'name' => 'required|min:5',
                'email' => 'sometimes|required|unique:users,email,' . $id);

            $validation = Validator::make($input, $rules);

            if ($validation->passes()) {
                $user = User::find($id);
                $user->update($input);
                return Redirect::route('users.index');
            }
            return Redirect::route('users.edit', $id)
                            ->withInput()
                            ->withErrors($validation)
                            ->with('message', 'There were validation errors.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $action_code = 'users_destroy';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            // Delete user
            User::find($id)->delete();
            return Redirect::route('users.index');
        }
    }

    // functions to manage permissions from a given role
}
