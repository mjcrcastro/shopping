<?php


class Product extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    // $ fillable are fields that can be sent as input
        
    public function product_descriptors() {
        return $this->belongsToMany('Descriptor','products_descriptors');
    }
    
    public function product_description() {
        foreach($this->product_descriptors as $descriptor) {
            $list = $descriptor->description + ', ';
        }
        return $list;
    }

   
}
