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
                        ->orderBy('descriptors.description','asc')
                        ->select('descriptors.id as descriptor_id', 'descriptors.description as label', 'descriptors_types.description as category')
                        ->join('descriptors_types', 'descriptors.descriptorType_id', '=', 'descriptors_types.id')
                        ->where('descriptors.description', 'like', '%' . $filter . '%')
                        ->get();
                return Response::json($descriptors);
            }else{
                return Response::make("Unable to comply request", 404);
            }
                
        }
    }
    
    public function products() {

        $action_code = 'descriptors_index';
        return json(Input::all());
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            if (Request::ajax()) {
                $filter = Input::get('term');
                //Will use the show function to return a json for ajax
                $descriptors = Descriptor::orderBy('descriptors_types.id', 'asc')
                        ->orderBy('descriptors.description','asc')
                        ->select('descriptors.id as descriptor_id', 'descriptors.description as label', 'descriptors_types.description as category')
                        ->join('descriptors_types', 'descriptors.descriptorType_id', '=', 'descriptors_types.id')
                        ->where('descriptors.description', 'like', '%' . $filter . '%')
                        ->get();
                return Response::json($descriptors);
            }else{
                return Response::make("Unable to comply request", 404);
            }
                
        }
    }

}
