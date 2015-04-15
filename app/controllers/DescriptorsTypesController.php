<?php

class DescriptorsTypesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Returns all shops to a view
        $action_code = 'descriptorsTypes_index';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $descriptorsTypes = DescriptorType::paginate(7);
            return View::make('descriptorsTypes.index', compact('descriptorsTypes'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of shops
        $action_code = 'descriptorsTypes_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            return View::make('descriptorsTypes.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //name of the action code, a corresponding entry in actions table
        $action_code = 'descriptorsTypes_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $input = Input::all();

            $validation = Validator::make($input, DescriptorType::$rules);

            if ($validation->passes()) {
                //if valid data, create a new shop
                $descriptorType = DescriptorType::create($input);
                //and return to the index
                return Redirect::route('descriptorsTypes.index')
                                ->with('message', 'Descriptor Type ' . $descriptorType->description . ' created');
            }
            //if data is not valid, return to edition for additional input
            return Redirect::route('descriptorsTypes.create')
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
        $action_code = 'descriptorsTypes_show';
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
        $action_code = 'descriptorsTypes_edit';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) { //I the user does not have permissions
            return Redirect::back()->with('message', $message);
        } else { //is the user has permissions
            //Actual code to execute
            $descriptorType = DescriptorType::find($id); //the the shop by the id

            if (is_null($descriptorType)) { //if no shop is found
                return Redirect::route('descriptorsTypes.index'); //go to previous page
            }
            //otherwise display the shop editor view
            return View::make('descriptorsTypes.edit', compact('descriptorType'));
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

        $action_code = 'descriptorsTypes_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            //Receives and updates new shop data
            $input = Input::all();
            //make sure the description is unique but 
            //exclude the $id for the current shop
            $rules = array('description' => 'required|unique:descriptors_types,description,' . $id);

            $validation = Validator::make($input, $rules);

            if ($validation->passes()) {
                $descriptorType = DescriptorType::find($id);
                $descriptorType->update($input);
                return Redirect::route('descriptorsTypes.index');
            }
            return Redirect::route('descriptorsTypes.edit', $id)
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
        $action_code = 'descriptorsTypes_destroy';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            DescriptorType::find($id)->delete();
            return Redirect::route('descriptorsTypes.index');
        }
    }

}
