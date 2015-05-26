<?php

class ShoppingListsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $action_code = 'shopping_lists_index';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }

        $filter = Input::get('filter');

        if ($filter) {

            $shoppingLists = ShoppingList::join('shops', 'shopping_lists.shop_id', '=', 'shops.id')
                    ->where('user_id', '=', Auth::user()->id)
                    ->whereRAW("shops.description like '%" . $filter . "%'")
                    ->orderBy('planned_date', 'desc')
                    ->paginate(Config::get('global/default.rows'));
        } else {

            $shoppingLists = ShoppingList::where('user', '=', Auth::user()->id)
                    ->orderBy('planned_date', 'desc')
                    ->paginate(Config::get('global/default.rows'));
        }

        return View::make('shoppingLists.index', compact('shoppingLists'))
                        ->with('filter', $filter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
        //first the list of companies

        $action_code = 'shopping_lists_create';

        $message = Helper::usercan($action_code, Auth::user());
        if ($message) {
            return Redirect::back()->with('message', $message);
        }
        //a return won't let the following code to continue

        return View::make('shoppingLists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
