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
            

            $filter = Input::get('term');
            
            //Will use the show function to return a json for ajax
            $descriptors = Descriptor::orderBy('descriptors.description', 'asc')
                    ->select('descriptors.id as descriptor_id',
                             'descriptors.description as label',
                             'descriptors_types.description as category')
                    ->join('descriptors_types','descriptors.descriptorType_id','=','descriptors_types.id')
                    ->where('descriptors.description', 'like', '%' . $filter . '%')
                    ->get();
            return Response::json($descriptors);
        }
    }
    
}
