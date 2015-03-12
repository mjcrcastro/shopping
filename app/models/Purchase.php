<?php


class Purchase extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'purchases';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    
    //returns a product this purchase relates to
    //eloquent will look for a product_id column in table purchases
    public function product() {
        return $this->belongsTo('Products');
    }
    
    //returns a shop this purchase was made in
    //eloquent will look for a shop_id column in table purchases
    public function shop() {
        return $this->belongsTo('Shops');
    }
    

   
}
