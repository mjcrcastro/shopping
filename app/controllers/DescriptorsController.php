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
        } else {

            $descriptorType_id = Input::get('descriptorType_id');
            $filter = Input::get('filter');

            if ($filter) {

                $descriptors = Descriptor::orderBy('description', 'asc')
                        ->where('description', 'like', '%' . $filter . '%')
                        ->where('descriptorType_id', '=', $descriptorType_id)
                        ->paginate(7);
            } else {
                $descriptors = Descriptor::orderBy('description', 'asc')
                        ->where('descriptorType_id', '=', $descriptorType_id)
                        ->paginate(7);
            }
            return View::make('descriptors.index', compact('descriptors'))
                            ->with('descriptorType_id', $descriptorType_id)
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

        $action_code = 'descriptors_create';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            return View::make('descriptors.create')
                            ->with('descriptorType_id', Input::get('descriptorType_id'));
        }
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
        } else {
            //Save new user data
            $input = Input::all();

            $validation = Validator::make($input, Descriptor::$rules);

            if ($validation->passes()) {

                $descriptor = Descriptor::create($input);

                $descriptorType_id = $descriptor->descriptorType_id;

                return Redirect::route('descriptors.index', array('descriptorType_id' => $descriptorType_id, 'filter' => Input::get('filter')));
            }
            return Redirect::route('descriptors.create')
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
        $action_code = 'descriptors_edit';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        } else {
            //Actual code to execute
            $descriptor = Descriptor::find($id);

            if (is_null($descriptor)) {
                return Redirect::route('descriptors.index', 
                        array('descriptorType_id' => Input::get('descriptorType_id'),
                            'filter' => Input::get('filter'))
                        );
            }
            return View::make('descriptors.edit', compact('descriptor'), 
                    array('descriptorType_id' => Input::get('descriptorType_id'),
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
                return Redirect::route('descriptors.index', 
                        array('descriptorType_id' => Input::get('descriptorType_id'),
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

            return Redirect::route('descriptors.index',
                    array('descriptorType_id'=>$descriptorType_id));
                    
        }
    }

}
