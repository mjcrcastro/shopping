<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Shop extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shops';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    
    public static $rules = array(
        'description' => 'required|unique:shops',
        'locationAddress'=>'required',
    );

    public function purchases() {
        return $this->hasMany('Purchase');
    }
       
}
