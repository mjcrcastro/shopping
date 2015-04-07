<?php

class DescriptorsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        //Return all descriptors

        $action_code = 'descriptors_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        $descriptorType_id = Input::get('descriptorType_id');
        $label = '';
        $filter = Input::get('filter');

        if ($filter and $descriptorType_id) {
            $descriptors = Descriptor::orderBy('description', 'asc')
                    ->where('description', 'like', '%' . $filter . '%')
                    ->where('descriptorType_id', '=', $descriptorType_id)
                    ->paginate(7);
            $label = ' for ' . DescriptorType::find($descriptorType_id)->description;
        } elseif ($descriptorType_id) {
            $descriptors = Descriptor::orderBy('description', 'asc')
                    ->where('descriptorType_id', '=', $descriptorType_id)
                    ->paginate(7);
            $label = ' for ' . DescriptorType::find($descriptorType_id)->description;
        } elseif ($filter) {
            $descriptors = Descriptor::orderBy('description', 'asc')
                    ->where('description', 'like', '%' . $filter . '%')
                    ->paginate(7);
        } else {
            $descriptors = Descriptor::orderBy('description', 'asc')
                    ->paginate(7);
        }
        return View::make('descriptors.index', compact('descriptors'))
                        ->with('descriptorType_id', $descriptorType_id)
                        ->with('filter', $filter)
                        ->with('label', $label);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //Display form for creation of roles

        $action_code = 'descriptors_create';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        $descriptorType_id = Input::get('descriptorType_id');
        $descriptorsTypes = DescriptorType::orderBy('description', 'asc')
                ->lists('description', 'id');
        $label = '';
        if ($descriptorType_id) {
            //say that the descriptor is of a specific descriptor type
            $label = ' for ' . DescriptorType::find($descriptorType_id)->description;
        }

        return View::make('descriptors.create')
                        ->with('descriptorType_id', $descriptorType_id)
                        ->with('descriptorsTypes', $descriptorsTypes)
                        ->with('label', $label);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $action_code = 'descriptors_store';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        //Save new user data
        $input = Input::all();

        $validation = Validator::make($input, Descriptor::$rules);

        if ($validation->passes()) {

            $descriptor = Descriptor::create($input);

            $descriptorType_id = $descriptor->descriptorType_id;
            
            if (Request::wantsJson()) {
                return Response::json($descriptor);
            }

            return Redirect::route('descriptors.index', array('descriptorType_id' => $descriptorType_id, 'filter' => Input::get('filter')));
        }



        return Redirect::route('descriptors.create')
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //Redirect to Company editor
        $action_code = 'descriptors_edit';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            $descriptor = Descriptor::find($id);
            $descriptorsTypes = DescriptorType::orderBy('description', 'asc')
                ->lists('description', 'id');

            if (is_null($descriptor)) {
                return Redirect::route('descriptors.index', array('descriptorType_id' => Input::get('descriptorType_id'),
                            'filter' => Input::get('filter'))
                );
            }
            return View::make('descriptors.edit', compact('descriptor','descriptorsTypes'), array('descriptorType_id' => Input::get('descriptorType_id'),
                        'filter' => Input::get('filter')));
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

        $action_code = 'descriptors_update';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            //Receives and updates new role  data
            $input = Input::all();

            $validation = Validator::make($input, Descriptor::$rules);

            if ($validation->passes()) {
                $descriptor = Descriptor::find($id);
                $descriptor->update($input);
                return Redirect::route('descriptors.index', array('descriptorType_id' => Input::get('descriptorType_id'),
                            'filter' => Input::get('filter'))
                );
            }
            //if errors, return to edition
            return Redirect::route('descriptors.edit', $id)
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
        $action_code = 'descriptors_destroy';
        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            $descriptor = Descriptor::find($id);
            $descriptorType_id = $descriptor->descriptorType_id;
            $descriptor->delete();

            return Redirect::route('descriptors.index', array('descriptorType_id' => $descriptorType_id));
        }
    }

    /*
     * Returns a json string with all desciptors from filter
     */

    public function jdescriptors() {

        $action_code = 'descriptors_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {

            if (Request::ajax()) {

                $filter = Input::get('term');
                //Will use the show function to return a json for ajax
                $descriptors = Descriptor::orderBy('description', 'asc')
                        ->where('description', 'like', '%' . $filter . '%')
                        ->get();
                return Response::json($descriptors);
            } else {
                return Response::make("Page not found", 404);
            }
        }
    }

}
