<?php

namespace App;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    protected $table = 'return_orders';
    protected $fillable = ['order_id','user_id','status','reason','order_detail_id','product_id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function order_details()
    {
        return $this->belongsTo(OrderDetail::class, 'order_details_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
