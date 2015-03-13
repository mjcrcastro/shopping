<?php

class BrandsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Returns all generics to a view
        $action_code ='brands_index';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $brands = Brand::paginate(7); //return all brands paginated to 7

            return View::make('brands.index', compact('brands'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of roles
        $action_code ='brands_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            return View::make('brands.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
        $action_code = 'brands_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $input = Input::all();

            $validation = Validator::make($input, Brand::$rules);

            if ($validation->passes()) {

                $brand = Brand::create($input);

                return Redirect::route('brands.index')
                                ->with('message', 'Brand ' . $brand->description . ' created');
            }
            return Redirect::route('brands.create')
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
        $action_code = 'brands_show';
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
        $action_code = 'brands_edit';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            $brand = Brand::find($id);

            if (is_null($brand)) {
                return Redirect::route('brands.index');
            }
            return View::make('brands.edit', compact('brand'));
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

        $action_code = 'brands_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            //Receives and updates new brands  data
            $input = Input::all();

            $rules = array('description' => 'required|unique:brands,description,' . $id);

            $validation = Validator::make($input, $rules);

            if ($validation->passes()) {
                $brand = Brand::find($id);
                $brand->update($input);
                return Redirect::route('brands.index');
            }
            return Redirect::route('brands.edit', $id)
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
        $action_code = 'brands_destroy';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            Brand::find($id)->delete();
            return Redirect::route('brands.index');
        }
    }

}
