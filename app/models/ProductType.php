<?php

class ProductType extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products_types';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    
    public static $rules = array(
        'description' => 'required|unique:products_types',
    );
    
    public function products() {
        return $this->hasMany('Product');
    }
    
}
