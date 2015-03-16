<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Descriptor extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'descriptors';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    
    public static $rules = array(
        'description' => 'required|unique:shops',
    );
    
    //returns all child descriptors 
    public function descriptors() {
        return $this->hasMany('Descriptor');
    }
    
    //returns parent descriptor
    public function descriptor() {
        return $this->belongsTo('Descriptor');
    }
    
    
}
