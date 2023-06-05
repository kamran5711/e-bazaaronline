<?php

namespace App\Models;
use App\StoreModal;
use App\Models\CouponUser;
use App\Models\OrderShipping;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    // protected $fillable=['user_id','store_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon','sale'];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $data = Order::where('store_id',auth()->user()->store_id)->count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }
    public function coupons(){
        return $this->hasMany(CouponUser::class);
    }

    public function store()
    {
        return $this->belongsTo(StoreModal::class, 'store_id', 'id');
    }

    public function shippings(){
        return $this->hasMany(OrderShipping::class, 'order_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function payment()
    {
        return $this->belongsTo('App\Payment', 'payment_id');
    }

    public function order_details()
    {
        return $this->hasMany(\App\Models\OrderDetail::class, 'order_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
