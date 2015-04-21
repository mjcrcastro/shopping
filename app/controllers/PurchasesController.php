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

        $products_purchases = Product::select('products_purchases.id', 'products.id as product_id', DB::raw($this->dbRaw()), 'products_purchases.amount', 'products_purchases.total')
                ->join('products_descriptors', 'products_descriptors.product_id', '=', 'products.id')
                ->join('descriptors', 'descriptors.id', '=', 'products_descriptors.descriptor_id')
                ->join('products_purchases', 'products.id', '=', 'products_purchases.product_id')
                ->where('products_purchases.purchase_id', '=', $purchase->id)
                ->groupBy('products.id')
                ->groupBy('products_purchases.id')
                ->orderBy('products.id')
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

        $message = Helper::usercan('purchases_update', Auth::user());

        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        //Helper::usercan return won't let the following code to continue

        $incoming_purchase = array(
            "shop_id" => Input::get('shop_id'),
            "purchase_date" => Input::get('purchase_date'),
            'updated_at' => date("Y-m-d H:i:s")
        );

        $purchaseDetails = $this->arrange_details(array(
            'purchase_id' => $id,
            'id' => Input::get('id'),
            'purchased_products' => Input::get('product_id'),
            'purchased_amount' => Input::get('amount'),
            'purchased_total' => Input::get('total')
        ));

        $purchaseValidation = Validator::make($incoming_purchase, Purchase::$rules);

        $detailValidation = Validator::make($purchaseDetails, ProductPurchase::$rules);

        if ($purchaseValidation->fails() || $detailValidation->fails()) {
            $bag = $purchaseValidation->messages()->merge($detailValidation->messages());
            return Redirect::route('purchases.edit', $id)
                            ->withInput()
                            ->withErrors($bag)
                            ->with('message', 'There were validation errors.');
        }

        $this->updatePurchaseDetails($id, $incoming_purchase, $purchaseDetails);

        return Redirect::route('purchases.index');
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

    private function arrange_details($fields) {

        $purchaseDetails = []; //need to initilaze so variable exists
        //even if no rows come in with $fields

        for ($nCount = 0; $nCount < count($fields['purchased_products']); $nCount++) {
            $purchaseDetails[] = array(
                        'id' => $fields['id'][$nCount],
                        'purchase_id' => $fields['purchase_id'],
                        'product_id' => $fields['purchased_products'][$nCount],
                        'amount' => $fields['purchased_amount'][$nCount],
                        'total' => $fields['purchased_total'][$nCount],
                        'updated_at' => date("Y-m-d H:i:s")
            );
        }
        return $purchaseDetails;
    }

    private function updatePurchaseDetails($purchase_id, $incomingPurchase, $purchaseDetails) {

        $purchase = Purchase::find($purchase_id);
        $purchase->update($incomingPurchase);
        
        //update those that were updated
        foreach ($purchaseDetails as $row) {

            if ($row['id'] === 'null') {
                //add those that were added
                //I can do it with a save since these are objects,
                //not arrays
                //store the newly created purchasesId as valid so 
                //I do not erase it by mistake
                $purchasesIds[] = ProductPurchase::create($row)->id;
            } else {
                $purchasesIds[] = $row['id']; //keep track of the incoming products_purchases.id
                $productPurchase = ProductPurchase::find($row['id']);
                $productPurchase->purchase_id = $row['purchase_id'];
                $productPurchase->product_id = $row['product_id'];
                $productPurchase->amount = $row['amount'];
                $productPurchase->total = $row['total'];
                $productPurchase->updated_at = $row['updated_at'];
                $productPurchase->save();
            }
        }
        //Remove from database those that are not present in
        //input, since they were removed from the view
        ProductPurchase::whereNotIn('id', $purchasesIds)
                ->where('purchase_id', '=', $purchase_id)
                ->delete();
    }

    private function dbRaw() {
        if (Config::get('database.default') === 'mysql') {
            return "GROUP_CONCAT(DISTINCT descriptors.description ORDER BY "
            . "descriptors.descriptorType_id SEPARATOR ' ') as product_description";
        } else {
            return "array_to_string(array_agg(descriptors.description ORDER BY descriptors.descriptortype_id), ' ' "
            . ") as product_description ";
        }
    }

}
