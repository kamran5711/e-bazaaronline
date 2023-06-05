<?php

namespace App;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $guarded=['id'];

    public function products(){
        return $this->hasMany('App\Models\Product');
    }
}
