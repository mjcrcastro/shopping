<?php

class HomeController extends \BaseController {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
     */

    public function showDashboard() {
        
        //first the list of companies
        
        return View::make('home.dashboard', compact('series', 'categories'));
    }
}
