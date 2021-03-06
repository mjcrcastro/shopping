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
        'product_type_id' => 'required',
    );
    
    public function productDescriptors(){
        return $this->hasMany('ProductDescriptor')
                ->join('descriptors','descriptors.id','=','products_descriptors.descriptor_id')
                ->orderBy('descriptors.descriptorType_id');
    }
    
    public function productType() {
        return $this->belongsTo('ProductType','product_type_id');
    }
    
    
    public static function boot()
    {
        parent::boot();    

        static::deleted(function($product)  {
            $product->productDescriptors()->delete();
        });
    }
}
