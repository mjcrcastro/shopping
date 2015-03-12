<?php

class ActionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Returns all companies to a view
            
            $actions = Action::paginate(7);
            
            return View::make('actions.index', compact('actions'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
              
            return View::make('actions.create');
	
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		 //Save new action data
            $input = Input::all();
                      
            $validation = Validator::make($input, Action::$rules);
                        
            if ($validation->passes())
            {
                $action = Action::create($input);
                                
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
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Redirect to Company editor
            
           $action = Action::find($id);
            if (is_null($action))
            {
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
	public function update($id)
	{
		//Receives and updates new company data
            $input  = Input::all();
            //This made only because when updating a user with the same username will faile.
            
            $validation = Validator::make($input, Action::$rules);
                   
            if ($validation->passes())
            {
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
	public function destroy($id)
	{
		//
	}


}
