<?php


class ProductDescriptor extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products_descriptors';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    // $ fillable are fields that can be sent as input
    public static $rules = array(
        'descriptor_id' => 'required',
        'product_id' => 'required',
    );
    
   
}
