<?php

class DescriptorType extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'descriptors_types';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    
    public static $rules = array(
        'description' => 'required|unique:descriptors_types',
    );
    
}
