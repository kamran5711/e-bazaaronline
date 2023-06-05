<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $guarded = [];
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }
}
