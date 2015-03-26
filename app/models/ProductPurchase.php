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
        'purchase_id' => 'required',
        'product_id' => 'required',
        'amount' => 'min:1',
        'total' => 'min:0',
    );
    
    public function purchase() {
        return $this->belongsTo('Purchase');
    }
    
    
    
   
}
