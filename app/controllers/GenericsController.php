<?php

class GenericsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Returns all generics to a view
        $action_code ='generics_index';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $generics = Generic::paginate(7);

            return View::make('generics.index', compact('generics'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of roles
        $action_code ='generics_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            return View::make('generics.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
        $action_code = 'generics_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $input = Input::all();

            $validation = Validator::make($input, Generic::$rules);

            if ($validation->passes()) {

                $generic = Generic::create($input);

                return Redirect::route('generics.index')
                                ->with('message', 'Generics ' . $generic->description . ' created');
            }
            return Redirect::route('generics.create')
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
        $action_code = 'generics_show';
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
        //Redirect to Company editor
        $action_code = 'generics_edit';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            $generic = Generic::find($id);

            if (is_null($generic)) {
                return Redirect::route('generics.index');
            }
            return View::make('generics.edit', compact('generic'));
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

        $action_code = 'generics_update';
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
                $generic = Generic::find($id);
                $generic->update($input);
                return Redirect::route('generics.index');
            }
            return Redirect::route('generics.edit', $id)
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
        $action_code = 'generics_destroy';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            Generic::find($id)->delete();
            return Redirect::route('generics.index');
        }
    }

}
