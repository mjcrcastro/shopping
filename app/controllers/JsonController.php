<?php

class JsonController extends \BaseController {
    /*
     * Returns a json string with all desciptors from filter
     */

    public function descriptors() {

        $action_code = 'descriptors_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            if (Request::ajax()) {
                $filter = Input::get('term');
                //Will use the show function to return a json for ajax
                $descriptors = Descriptor::orderBy('descriptors_types.id', 'asc')
                        ->orderBy('descriptors.description', 'asc')
                        ->select('descriptors.id as descriptor_id', 'descriptors.description as label', 'descriptors_types.description as category')
                        ->join('descriptors_types', 'descriptors.descriptorType_id', '=', 'descriptors_types.id')
                        ->where('descriptors.description', 'like', '%' . $filter . '%')
                        ->get();
                return Response::json($descriptors);
            } else {
                return Response::make("Unable to comply request", 404);
            }
        }
    }

    public function products() {

        $action_code = 'descriptors_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //if (Request::ajax()) {
                $filter = Input::get('search.value');
                if ($filter) {
                    //this query depends on the definition of 
                    //function productDescriptors in the products model
                    //productDescriptors returns all of this product descriptors
                    //decompose the incoming string in
                    
                    $products = Product::select('products.id',
                             DB::raw('GROUP_CONCAT(DISTINCT descriptors.description ORDER BY descriptors.descriptorType_id SEPARATOR " ") as product_description'))
                            ->join('products_descriptors','products_descriptors.product_id','=','products.id')
                            ->join('descriptors','descriptors.id','=','products_descriptors.descriptor_id')
                            ->groupBy('products.id')
                            ->havingRaw($this->getHavingRaw($filter))
                            ->get();
                } else {
                    $products = Product::select('products.id',
                             DB::raw('GROUP_CONCAT(DISTINCT descriptors.description ORDER BY descriptors.descriptorType_id SEPARATOR " ") as product_description'))
                            ->join('products_descriptors','products_descriptors.product_id','=','products.id')
                            ->join('descriptors','descriptors.id','=','products_descriptors.descriptor_id')
                            ->groupBy('products.id')
                            ->get();
                }
                
            }
                
                $response['length'] = Input::get('length');
                $response['draw'] = Input::get('draw');
                $response['recordsTotal'] = Product::all()->count();
                $response['recordsFiltered'] = $products->count();
                $response['data'] = $products->all();
                return Response::json($response);
            //}
        }
        /*
         * Receives a seach string and converts every word into individual
         * words that are used to prepare a havingRaw clause for a search of product
         * in function $this->products
         */
        public function getHavingRaw($search_string) {
            $searchArray = explode(" ",$search_string);
            
            static $having;
            
            for($nCount = 0; $nCount < sizeof($searchArray);$nCount++){
                $having.=' AND GROUP_CONCAT(DISTINCT descriptors.description) '.
                        'like "%'.ltrim(rtrim($searchArray[$nCount])).'%"';
            }
            return substr($having,5,strlen($having)-5);
        }
    }

