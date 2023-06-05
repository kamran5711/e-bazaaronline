<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $guarded = [];
    // public $timestamps = false;

    
    // public function carts(){
    //     return $this->hasMany(Cart::class)->whereNotNull('order_id');
    // }

    public function productStockSize(){
        return $this->hasMany(ProductStock::class);
    }
}
