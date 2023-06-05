<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
   protected $table =   'sizes';
    protected $fillable = ['product_id','title'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
