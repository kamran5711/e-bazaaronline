<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $guarded=['id'];
    public $timestamps = false;

    
    public function carts()
    {
     return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }
}
