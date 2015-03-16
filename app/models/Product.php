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
        
    public function productDescriptors() {
        return $this->hasMany('ProductDescriptor');
    }
    
    public function description() {
        foreach($this->productDescriptors as $productDescriptor) {
            $list = $productDescriptor->description + ', ';
        }
        return $list;
    }

   
}
