<?php

class JsonController extends \BaseController {
    /*
     * Returns a json string with all desciptors from filter
     */

    public function descriptors() {

        $action_code = 'descriptors_index';

        $message = Helper::usercan($action_code, Auth::user());
        
        if ($message) { return Redirect::back()->with('message', $message); }
        
        if (Request::ajax()) {//only return data to ajax calls
            
            $filter = Input::get('term');

            $descriptors = Descriptor::select('descriptors.id as descriptor_id', 
                            'descriptors.description as label', 
                            'descriptors_types.description as category', 
                            'descriptors.descriptorType_id')
                    ->join('descriptors_types', 
                            'descriptors.descriptorType_id', '=', 
                            'descriptors_types.id')
                    ->whereRaw("LOWER(descriptors.description) like '%" . 
                            strtolower($filter) . "%'")
                    ->orderBy('descriptors_types.id', 'asc')
                    ->orderBy('descriptors.description', 'asc')->get();
            
            return Response::json($descriptors);
            
        } else {
            
            return Response::make("Unable to comply request", 404);
            
        }
    }

    public function products() {

        $action_code = 'products_list_json';

        $message = Helper::usercan($action_code, Auth::user());
        
        if ($message) { return Redirect::back()->with('message', $message); }
        
        if (Request::ajax()) {//return json data only to ajax queries
            
        $filter = Input::get('search.value');
        
        $dbRaw = $this->getDbRaw();
        
        $products = $this->getProducts($filter, $dbRaw);
        
        $response['draw'] = Input::get('draw');
        
        $response['recordsTotal'] = Product::all()->count();
        
        $response['recordsFiltered'] = $products->get()->count();
        
        $response['data'] = $products
                ->skip(Input::get('start'))
                ->take(Input::get('length'))
                ->get();
        
        return Response::json($response);
        
        }
    }
    
    public function productsShoppingList() {

        $action_code = 'products_shopping_list_json';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) { return Redirect::back()->with('message', $message); }
        
        if (Request::ajax()) {
        
        $filter = Input::get('search.value');
        
        $dbRaw = $this->getDbRaw();
        
        $products = $this->getProductsShoppingList($filter, $dbRaw);
        
        $response['draw'] = Input::get('draw');
        $response['recordsTotal'] = Product::all()->count();
        $response['recordsFiltered'] = $products->get()->count();
        
        $response['data'] = $products
                ->skip(Input::get('start'))
                ->take(Input::get('length'))
                ->get();
        
        return Response::json($response);
        
        }
    }

    /*
     * Receives a seach string and converts every word into individual
     * words that are used to prepare a havingRaw clause for a search of product
     * in function $this->products
     */

    private function getHavingRaw($search_string) {

        $searchArray = explode(" ", $search_string);

        static $having = '';
        //creates a having query for each incoming word
        for ($nCount = 0; $nCount < sizeof($searchArray); $nCount++) {
            if (Config::get('database.default') === 'mysql') {
                $having.=" AND GROUP_CONCAT(descriptors.description) " .
                        "like '%" . strtolower(ltrim(rtrim($searchArray[$nCount]))) . "%'";
            } else {
                $having.=" AND string_agg(LOWER(descriptors.description), ' ' ORDER BY descriptors.\"descriptorType_id\") " .
                        "like  '%" . strtolower(ltrim(rtrim($searchArray[$nCount]))) . "%'";
            }
        }
        
        return substr($having, 5, strlen($having) - 5);
    }
    
    private function getProductsShoppingList($filter, $dbRaw) {
        
        $products = Product::select('products.id as product_id', 
                'shops.description as shop', 
                DB::raw("to_char(purchases.purchase_date,'YYYY MM DD') as date"),
                DB::raw($dbRaw), 
                DB::raw('round(avg(products_purchases.total / '
                        . 'products_purchases.amount)::numeric,2) '
                        . 'as price')
                )
                ->join('products_descriptors', 'products_descriptors.product_id', '=', 'products.id')
                ->join('products_purchases','products.id','=','products_purchases.product_id')
                ->join('purchases','products_purchases.purchase_id','=','purchases.id')
                ->join('shops','purchases.shop_id','=','shops.id')
                ->join('descriptors', 'descriptors.id', '=', 'products_descriptors.descriptor_id')
                ->groupBy('products.id')
                ->groupBy('shops.id')
                ->groupBy('purchases.purchase_date');
        
        if ($filter) {   
            
            $products = $products->havingRaw($this->getHavingRaw($filter)); 
        
        }
            
        return $products;
        
    }
    
    private function getDbRaw() {
        if (Config::get('database.default') === 'mysql') {
            
            $dbRaw = "GROUP_CONCAT(DISTINCT descriptors.description "
                    . "ORDER BY descriptors.descriptorType_id SEPARATOR ' ') "
                    . "as product_description";
        } else {
            
            $dbRaw = "string_agg(descriptors.description, ' ' "
                    . "ORDER BY descriptors.\"descriptorType_id\") "
                    . "as product_description";
        }
        
        return $dbRaw;
    }
    
    private function getProducts($filter, $dbRaw) {
        if ($filter) {
            
            $products = Product::select('products.id as product_id', DB::raw($dbRaw) )
                    ->join('products_descriptors', 'products_descriptors.product_id', '=', 'products.id')
                    ->join('descriptors', 'descriptors.id', '=', 'products_descriptors.descriptor_id')
                    ->groupBy('products.id')
                    ->havingRaw($this->getHavingRaw($filter));
        } else {
            $products = Product::select('products.id as product_id', DB::raw($dbRaw))
                    ->join('products_descriptors', 'products_descriptors.product_id', '=', 'products.id')
                    ->join('descriptors', 'descriptors.id', '=', 'products_descriptors.descriptor_id')
                    ->groupBy('products.id');
        }
        
        return $products;
    }

}
