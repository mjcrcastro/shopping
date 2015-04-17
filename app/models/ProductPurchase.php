<?php

class ProductPurchase extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products_purchases';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    // $ fillable are fields that can be send as input
    public static $rules = array(
        'purchase_id' => 'required|array|each',
        'product_id' => 'required|array|each',
        'amount' => 'array|each:min:1',
        'total' => 'array|each|min:0',
    );
    
    public function purchase() {
        return $this->belongsTo('Purchase');
    }
    
    public function product() {
        return $this->belongsTo('Product');
    }
    
    
    
   
}
