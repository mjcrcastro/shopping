<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Generic extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'generics';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    
    public static $rules = array(
        'description' => 'required|unique:roles',
    );

    public function permissions() {
        return $this->hasMany('Product');
    }

}
