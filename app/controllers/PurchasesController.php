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
            $purchases = Purchase::whereHas('Shop', function($q) {
                        $q->where('description', 'like', '' . '%' . Input::get('filter') . '' . '%')
                                ->orWhere('purchase_date', 'like', '' . '%' . Input::get('filter') . '' . '%');
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

        $shops = Shop::orderBy('description', 'asc')->lists('description', 'id');

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
            "user" => Auth::user()->username,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        );

        $purchasedProducts = Input::get('product_id');

        if (!$purchasedProducts) {
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
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                );
            }

            $detailValidation = Validator::make($purchaseDetails, ProductPurchase::$rules);

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
        $action_code = 'purchases_edit';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }//a return won't let the following code to continue
        //Actual code to execute
        $purchase = Purchase::find($id);

        if (is_null($purchase)) {
            return Redirect::route('purchases.index');
        }

        $shops = Shop::orderBy('description', 'asc')->lists('description', 'id');

        if (Config::get('database.default') === 'mysql') {
            $dbRaw = "GROUP_CONCAT(DISTINCT descriptors.description ORDER BY descriptors.descriptorType_id SEPARATOR ' ') as description";
        } else {
            $dbRaw = "array_to_string(array_agg(descriptors.description), ' ') as product_description";
        }

        $products_purchases = Product::select('products.id as product_id', DB::raw($dbRaw), 'products_purchases.amount', 'products_purchases.total')
                ->join('products_descriptors', 'products_descriptors.product_id', '=', 'products.id')
                ->join('descriptors', 'descriptors.id', '=', 'products_descriptors.descriptor_id')
                ->join('products_purchases', 'products.id', '=', 'products_purchases.product_id')
                ->where('products_purchases.purchase_id', '=', $purchase->id)
                ->groupBy('products.id')
                ->get();
        return View::make('purchases.edit', compact('purchase', 'shops', 'products_purchases'));
        // End of actual code to execute
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $action_code = 'purchases_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) { return Redirect::back()->with('message', $message);}//a return won't let the following code to continue
        //
        //Actual code to execute
        //Receives and updates new role  data
        $input = Input::all();

        $purchaseData = array(
            "shop_id" => Input::get('shop_id'),
            "purchase_date" => Input::get('purchase_date'),
            'updated_at' => date("Y-m-d H:i:s")
        );

        $purchasedProducts = Input::get('product_id');
        $purchasedAmount = Input::get('amount'); //comes as an array
        $purchasedTotal = Input::get('total'); //comes an array

        arrange_validate_details ($purchasedProducts,
            $purchasedAmount, 
            $purchasedTotal,
            $purchaseDetails,
            $rulesArray);

        $purchaseValidation = Validator::make($input, Purchase::$rules);

        $detailValidation = Validator::make($purchaseDetails, $rulesArray);

        if ($purchaseValidation->passes() && $detailValidation->passes()) {

            $purchase = Purchase::find($id);
            $purchase->update($purchaseData);
            $purchase->productsPurchases->updateMany($purchaseDetails);

            return Redirect::route('purchases.index');
        }
        return Redirect::route('purchases.edit', $id)
                        ->withInput()
                        ->withErrors($detailValidation)
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
    
    private function arrange_validate_details (
            $purchasedProducts,
            $purchasedAmount, 
            $purchasedTotal,
            &$purchaseDetails,
            &$rulesArray
            ) {
        for ($nCount = 0; $nCount < count($purchasedProducts); $nCount++) {
            $purchaseDetails[] = new ProductPurchase(
                    array(
                'purchase_id' => $id,
                'product_id' => $purchasedProducts[$nCount],
                'amount' => $purchasedAmount[$nCount],
                'total' => $purchasedTotal[$nCount],
                'updated_at' => date("Y-m-d H:i:s")
                    )
            );

            $rulesArray['purchase_id' . $nCount] = ProductPurchase::$rules['purchase_id'];
            $rulesArray['product_id'] = ProductPurchase::$rules['product_id'];
            $rulesArray['amount'] = ProductPurchase::$rules['amount'];
            $rulesArray['total'] = ProductPurchase::$rules['total'];
            $rulesArray['updated_at'] = ProductPurchase::$rules['updated_at'];
        }
    }

}
