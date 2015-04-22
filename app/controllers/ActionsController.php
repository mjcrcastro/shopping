<?php

class ActionsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $message = Helper::usercan('actions_index', Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }


        $actions = Action::orderBy('code')
                ->paginate(7);

        return View::make('actions.index', compact('actions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $message = Helper::usercan('actions_create', Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }

        return View::make('actions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
$message = Helper::usercan('actions_store', Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        //Save new action data
        $input = Input::all();

        /* @var $validation validation object */
        $validation = Validator::make($input, Action::$rules);

        if ($validation->passes()) {
            Action::create($input);

            return Redirect::route('actions.index')
                            ->with('message', 'Action Created');
        }
        return Redirect::route('actions.create')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
$message = Helper::usercan('actions_edit', Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }

        $action = Action::find($id);
        if (is_null($action)) {
            return Redirect::route('actions.index');
        }
        return View::make('actions.edit', compact('action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
$message = Helper::usercan('actions_update', Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        $input = Input::all();

        $validation = Validator::make($input, Action::$rules);

        if ($validation->passes()) {
            $action = Action::find($id);
            $action->update($input);
            return Redirect::route('actions.index');
        }
        return Redirect::route('actions.edit', $id)
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
        $message = Helper::usercan('actions_destroy', Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
    }

}
