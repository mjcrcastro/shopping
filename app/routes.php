<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

Route::group(array('before' => 'auth'), function() {
    //routes within this group require authentication
    Route::get('/getdata',array('uses'=>'HomeController@getData'));
    
    Route::get('/', array('uses' => 'HomeController@showDashboard'));

    Route::get('/about', array('uses' => 'HomeController@showDashboard'));

    Route::resource('users', 'UsersController');

    Route::resource('roles', 'RolesController');

    Route::resource('permissions', 'PermissionsController');

    Route::resource('actions', 'ActionsController');

    Route::resource('shops', 'ShopsController');

    Route::resource('products', 'ProductsController');

    Route::get('descriptorsTypes/getcsv', array(
        'as' => 'descriptorsTypes.getcsv',
        'uses' => 'DescriptorsTypesController@getCsv'
    ));
    Route::resource('descriptorsTypes', 'DescriptorsTypesController');
    //it is required to add the addiontional routes before the call to Route::resource
    //if the additional route is added, Laravel wont be able to handle the get 
    //request from descriptors (i.e. /descriptors/tocsv, 
    //we would have to call it from the root // (i.e. /tocsv)
    Route::get('descriptors/getcsv', array(
        'as' => 'descriptors.getcsv',
        'uses' => 'DescriptorsController@getCsv'
    ));
    Route::resource('descriptors', 'DescriptorsController');

    Route::resource('purchases', 'PurchasesController');

    Route::get('jdescriptors', array('uses' => 'JsonController@descriptors'));
    Route::get('jproducts', array('uses' => 'JsonController@products'));
});

// All this do not need to request authentication since they are doing 
// the authentication
// route to show the login form
Route::get('login', array('uses' => 'LoginController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'LoginController@doLogin'));

//Logout route
Route::get('logout', array('uses' => 'LoginController@doLogout'));

//Route to denied page
Route::get('denied', array('uses' => 'LoginController@denied'));

//To tell the user that the resource was not found.
App::missing(function($exception) {
    return Response::make("Page not found", 404);
});
