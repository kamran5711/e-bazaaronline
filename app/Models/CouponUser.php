<?php

namespace App\Models;
use App\StoreModal;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    public $timestamps = false;
    protected $fillable = ['coupon_id', 'value', 'store_id', 'order_id', 'user_id'];

    public function store()
    {
        return $this->belongsTo(StoreModal::class, 'store_id', 'id');
    }
}
