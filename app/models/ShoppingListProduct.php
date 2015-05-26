<?php

class shoppingListProduct extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shopping_lists_products';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    // $ fillable are fields that can be send as input
    public static $rules = array(
        'amount' => 'array|each:min:1',
        'total' => 'array|each|min:0',
    );
    
    public function purchase() {
        return $this->belongsTo('ShoppingList');
    }
    
    public function product() {
        return $this->belongsTo('Product');
    }
    
    
    
   
}
