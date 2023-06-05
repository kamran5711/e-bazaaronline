<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $guarded = [];
    // public function products(){
    //     return $this->hasMany('App\Models\Product','brand_id','id')->where('status','active');
    // }
    // public static function getProductByBrand($slug){
    //     return Brand::with('products')
        
    //     ->where('slug',$slug)->first();
    // }

    public function productStockColor(){
        return $this->hasMany(ProductStock::class);
    }
}
