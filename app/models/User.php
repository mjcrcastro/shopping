<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');
    // $guarded are fields that can not be sent as input
    protected $guarded = array('id');
    // $ fillable are fields that can be sent as input
    protected $fillable = array('email', 'username', 'name');
    
    public static $rules = array(
        'username' => 'sometimes|required|min:8|unique:users',
        'password' => 'confirmed',
        'name' => 'required|min:5',
        'email' => 'sometimes|required|email|unique:users'
    );

    public function role() {
        return $this->belongsTo('Role');
    }

}
