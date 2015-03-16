<?php

class ProductsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Return all products

        $action_code = 'products_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {

            $filter = Input::get('filter');

            if ($filter) {
                
                $products = Product::whereHas('descriptors', function($q)
                {
                    $q->where('description', 'like', '%' . $filter . '%');

                })->paginate(Config::get('global/default.rows'));
                
                return View::make('products.index', compact('products'))
                                ->with('filter', $filter);
            } else {
                $products = Product::paginate(Config::get('global/default.rows'));

                return View::make('products.index', compact('products'))
                                ->with('filter', $filter);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of roles

        $action_code = 'products_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            return View::make('products.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $action_code = 'products_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Save new user data
            $input = Input::all();

            $validation = Validator::make($input, Product::$rules);

            if ($validation->passes()) {

                $product = new Product;
                
                $product->description = Input::get('description');
                $product->short_description = Input::get('short_description');
                $product->save();
                
                $product_code = new ProductCode;
                
                $product_code->description = Input::get('product_code'); 
                $product_code->product_id = $product->id; 
                $product_code->save();

                return Redirect::route('products.index');
            }
            return Redirect::route('products.create')
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
        //Redirect to Company editor
        $action_code = 'products_edit';
        
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            $product = Product::find($id);

            if (is_null($product)) {
                return Redirect::route('products.index');
            }
            return View::make('products.edit', compact('product'));
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

        $action_code = 'products_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            //Receives and updates new role  data
            $input = Input::all();

            $rules = array('short_description' => 'required|unique:products,description,' . $id,
                'description' => 'required',);

            $validation = Validator::make($input, $rules);

            if ($validation->passes()) {
                $product = Product::find($id);
                $product->update($input);
                return Redirect::route('products.index');
            }
            return Redirect::route('products.edit', $id)
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
        $action_code = 'products_delete';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            Product::find($id)->delete();
            return Redirect::route('products.index');
        }
    }

}
