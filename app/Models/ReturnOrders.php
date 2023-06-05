<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ReturnOrders extends Model
{
    protected $guarded = [];
    public function order_detail()
    {
        return $this->belongsTo(OrderDetail::class, 'order_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
