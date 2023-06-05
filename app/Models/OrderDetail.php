<?php

namespace App\Models;
use App\Models\ReturnOrders;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{

  protected $guarded = [];
  protected $table = 'order_details';
//   public $timestamps = false;


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'choice_id', 'id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function return_order()
    {
       return $this->hasOne(ReturnOrders::class, 'order_detail_id', 'id');
    }

}
