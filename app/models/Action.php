<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Action extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'actions';
        
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        protected $guarded = array('id');

         public static $rules = array (
            'code'=>'required',
            'description'=>'required',
        );


}
