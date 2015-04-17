<?php

class ShopsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Returns all shops to a view
        $message = Helper::usercan('shops_index', Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        $shops = Shop::paginate(7);

        return View::make('shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of shops
        $message = Helper::usercan('shops_create', Auth::user());
        
        if ($message) { return Redirect::back()->with('message', $message); } 
       
        return View::make('shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //name of the action code, a corresponding entry in actions table
        $action_code = 'shops_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $input = Input::all();

            $validation = Validator::make($input, Shop::$rules);

            if ($validation->passes()) {
                //if valid data, create a new shop
                $shop = Shop::create($input);
                //and return to the index
                return Redirect::route('shops.index')
                                ->with('message', 'Shop ' . $shop->description . ' created');
            }
            //if data is not valid, return to edition for additional input
            return Redirect::route('shops.create')
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
    //I do not actually use this function since is is a simple object
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

        $action_code = 'shops_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            //Receives and updates new shop data
            $input = Input::all();
            //make sure the description is unique but 
            //exclude the $id for the current shop
            $rules = array('description' => 'required|unique:shops,description,' . $id);

            $validation = Validator::make($input, $rules);

            if ($validation->passes()) {
                $shop = Shop::find($id);
                $shop->update($input);
                return Redirect::route('shops.index');
            }
            return Redirect::route('shops.edit', $id)
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
        $action_code = 'shops_destroy';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            Shop::find($id)->delete();
            return Redirect::route('shops.index');
        }
    }

}
