<?php


class ShoppingList extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shopping_lists';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    
    public static $rules = array(
        'shop_id' => 'required',
        'planned_date' => 'required',
    );

    //returns a product this purchase relates to
    //returns a shop this purchase was made in
    //eloquent will look for a shop_id column in table purchases
    public function shop() {
        return $this->belongsTo('Shop');
    }
    
    public function user() {
        return $this->belongsTo('User');
    }
    
    public function productsShoppingList() {
        return $this->hasMany('ProductPurchase');
    }
    //called upon being deleted
    //deletes all childs
    protected static function boot() {
        parent::boot();
        static::deleting(function($purchase) { // called BEFORE delete()
            $purchase->productsPurchases()->delete();
        });
    }
    

   
}
