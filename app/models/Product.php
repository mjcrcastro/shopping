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
    public static $rules = array(
        'description' => 'required|unique:products,description',
        'short_description' => 'required',
    );
    
    public function productcodes() {
        return $this->hasMany('ProductCode');
    }
    
    public function productcodesList() {
        foreach($this->productcodes as $productcode) {
            $list = $productcode->description;
        }
        if($list) {
            $list = substr($list,1,50);
        }else{
        }
        
    }

   
}
