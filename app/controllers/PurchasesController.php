<?php

class PurchasesController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Return all purchases

        $action_code = 'purchases_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }//a return won't let the following code to continue

        $filter = Input::get('filter');
        
        if ($filter) {
            //this query depends on the definition of 
            //function productDescriptors in the products model
            //productDescriptors returns all of this product descriptors
            $purchases = Purchase::whereHas('Shop', function($q)
                {
                    $q->where('description', 'like', ''.'%'.Input::get('filter').''.'%')
                      ->orWhere('purchase_date', 'like', ''.'%'.Input::get('filter').''.'%');
                })->paginate(Config::get('global/default.rows'));
            
            return View::make('products.index', compact('purchases'))
                            ->with('filter', $filter);
        } else {
            
            $purchases = Purchase::paginate(Config::get('global/default.rows'));

            return View::make('purchases.index', compact('purchases'))
                            ->with('filter', $filter);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of roles

        $action_code = 'purchases_create';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }//a return won't let the following code to continue

        $shops = Shop::orderBy('description','asc')->lists('description', 'id');

        return View::make('purchases.create', compact('shops'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $action_code = 'products_store';
        
        return Input::all();
        
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }//a return won't let the following code to continue
        //Receives and updates new company data
        $descriptors = Input::get('descriptors');

        // check if the product has already been created
        if (!Helper::productGet($descriptors)) {//check for duplicate products
            $product = new Product;
            $product->save();

            //modify the array so that it includes the product id
            foreach ($descriptors as &$row) {
                $data[] = array('product_id' => $product->id, 'descriptor_id' => $row);
            }

            ProductDescriptor::insert($data);

            return Redirect::route('products.index');
        } else {
            return Redirect::back()->with('message', 'Product already in database');
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
        }//a return won't let the following code to continue
        //Actual code to execute
        $product = Product::find($id);

        if (is_null($product)) {
            return Redirect::route('products.index');
        }
        return View::make('products.edit', compact('product'));
        // End of actual code to execute
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
        }//a return won't let the following code to continue
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
        $action_code = 'products_destroy';
        $message = Helper::usercan($action_code, Auth::user());

        if ($message) {
            return Redirect::back()->with('message', $message);
        }//a return won't let the following code to continue
        Product::find($id)->delete();
        return Redirect::route('products.index');
    }

}
