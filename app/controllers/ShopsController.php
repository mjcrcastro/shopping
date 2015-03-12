<?php

class shopsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Returns all roles to a view
        $action_code ='shops_index';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $shops = Shop::paginate(7);

            return View::make('shops.index', compact('shops'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of roles
        $action_code ='shops_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            return View::make('shops.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
        $action_code = 'shops_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $input = Input::all();

            $validation = Validator::make($input, Shop::$rules);

            if ($validation->passes()) {

                $shop = Shop::create($input);

                return Redirect::route('shops.index')
                                ->with('message', 'Shop ' . $shop->description . ' created');
            }
            return Redirect::route('shop.create')
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
        $action_code = 'shops_show';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //
            return Redirect::to('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //Redirect to Shops editor
        $action_code = 'shops_edit';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) { //I the user does not have permissions
            return Redirect::back()->with('message', $message);
        } else { //is the user has permissions
            //Actual code to execute
            $shop = Shop::find($id); //the the shop by the id

            if (is_null($shop)) { //if no shop is found
                return Redirect::route('shops.index'); //go to previous page
            }
            //otherwise display the shop editor view
            return View::make('shops.edit', compact('shop'));
            // End of actual code to execute
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $action_code = 'roles_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            //Receives and updates new role  data
            $input = Input::all();

            $rules = array('description' => 'required|unique:roles,description,' . $id);

            $validation = Validator::make($input, $rules);

            if ($validation->passes()) {
                $role = Role::find($id);
                $role->update($input);
                return Redirect::route('roles.index');
            }
            return Redirect::route('roles.edit', $id)
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
        //
        $action_code = 'roles_delete';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            Role::find($id)->delete();
            return Redirect::route('roles.index');
        }
    }

}
