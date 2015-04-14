<?php

class LoginController extends \BaseController {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
     */

    public function showLogin() {
        return View::make('login.showlogin');
    }

    public function doLogin() {

        // validate the info, create rules for the inputs
        $rules = array(
            'username' => 'required', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:6' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('login')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata = array(
                'username' => Input::get('username'),
                'password' => Input::get('password'),
            );

            // attempt to do the login
            if (Auth::attempt($userdata)) {
                return redirect()->intended('/');
            } else {
                // validation not successful, send back to form	
                return Redirect::to('login')
                                ->with('message','Login unsucessfull')
                                ->withInput(Input::except('password'));
            }
        }
    }

    public function doLogout() {
        /* For logout, we will flush and clean out the session and then 
         * redirect our user back to the login screen. You can change 
         * this to redirect a user wherever you would like. A home page 
         * or even a sad goodbye page.
         */
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
    
    
    public function denied() {
        /* For logout, we will flush and clean out the session and then 
         * redirect our user back to the login screen. You can change 
         * this to redirect a user wherever you would like. A home page 
         * or even a sad goodbye page.
         */
        return View::make('denied'); // redirect the user to the login screen
    }
    

}
