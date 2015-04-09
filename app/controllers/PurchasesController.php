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

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }//a return won't let the following code to continue
        //Receives and updates new purchase data

        $purchaseData = array(
            "shop_id" => Input::get('shop_id'),
            "purchase_date" => Input::get('purchase_date'),
            "user"=>Auth::user()->username,
            'created_at'=>date("Y-m-d H:i:s"),
            'updated_at'=>date("Y-m-d H:i:s")
                );
        
        $purchasedProducts = Input::get('product_id');
        
        if(!$purchasedProducts) {
           return Redirect::route('purchases.create')
                    ->withInput()
                    ->with('message', 'No product was found'); 
        }
        
        $validation = Validator::make($purchaseData, Purchase::$rules);
        
        
        if ($validation->passes()) {
            
            $purchase = Purchase::create($purchaseData);

            $purchasedAmount = Input::get('amount');
            $purchasedTotal = Input::get('total');
            
            for ($nCount = 0; $nCount < count($purchasedProducts); $nCount++) {
                $purchaseDetails[] = array('purchase_id' => $purchase->id, 
                                'product_id' => $purchasedProducts[$nCount],
                                'amount' => $purchasedAmount[$nCount],
                                'total' => $purchasedTotal[$nCount],
                    );
            }
                 
            $detailValidation = Validator::make($purchaseDetails, Purchase::$rules);    
                
            ProductPurchase::insert($purchaseDetails);
                
            return Redirect::route('purchases.index')
                    ->withInput()
                    ->withErrors($detailValidation)
                    ->with('message', 'Purchase Created');    
        } else {
            return Redirect::route('purchases.create')
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
        $action_code = 'purchases_destroy';
        $message = Helper::usercan($action_code, Auth::user());

        if ($message) {
            return Redirect::back()->with('message', $message);
        }//a return won't let the following code to continue
        Purchase::find($id)->delete();
        return Redirect::route('purchases.index');
    }

}
