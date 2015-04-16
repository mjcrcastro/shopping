<?php

class ProductsTypesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //
        $action_code = 'products_types_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }

        $productsTypes = ProductType::paginate(7);

        return View::make('productsTypes.index', compact('productsTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of products types
        $action_code = 'products_types_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }

        return View::make('productsTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
        $action_code = 'products_types_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        $input = Input::all();

        $validation = Validator::make($input, ProductType::$rules);

        if ($validation->passes()) {
            //if valid data, create a new shop
            $productType = ProductType::create($input);
            //and return to the index
            return Redirect::route('productsTypes.index')
                            ->with('message', 'Product Type ' . $productType->description . ' created');
        }
        //if data is not valid, return to edition for additional input
        return Redirect::route('productsTypes.create')
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors');
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
        //Redirect to Products Types editor
        $action_code = 'products_types_edit';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) { //If the user does not have permissions
            return Redirect::back()->with('message', $message);
        }
        //Actual code to execute
        $productType = ProductType::find($id); //the the product type by the id

        if (is_null($productType)) { //if no product type is found
            return Redirect::route('productsTypes.index'); //go to previous page
        }
        //otherwise display the products types editor view
        return View::make('productsTypes.edit', compact('productType'));
        // End of actual code to execute
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $action_code = 'products_types_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        //Actual code to execute
        //Receives and updates new shop data
        $input = Input::all();
        //make sure the description is unique but 
        //exclude the $id for the current shop
        $rules = array('description' => 'required|unique:products_types,description,' . $id);

        $validation = Validator::make($input, $rules);

        if ($validation->passes()) {
            $productType = ProductType::find($id);
            $productType->update($input);
            return Redirect::route('productsTypes.index');
        }
        return Redirect::route('productsTypes.edit', $id)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
        $action_code = 'products_types_destroy';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        ProductType::find($id)->delete();
        return Redirect::route('productsTypes.index');
    }

}
