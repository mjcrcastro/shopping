<?php

use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Role extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

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
        return $this->hasMany('Permission');
    }
    
    public function actions() {
         return $this->belongsToMany('Action','roles_actions');
    }
    
    public static function boot()
    {
        parent::boot();    

        static::deleted(function($role)
        {
            $role->permissions()->delete();
        });
    }

}
