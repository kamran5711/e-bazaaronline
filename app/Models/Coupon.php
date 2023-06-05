<?php

namespace App\Models;
use App\StoreModal;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code','expiry_date','value','status','store_id'];

    public static function findByCode($code){
        return self::where('code', $code)->first();
    }
    public function discount($total){
        if($this->type=="fixed"){
            return $this->value;
        }
        elseif($this->type=="percent"){
            return ($this->value /100)*$total;
        }
        else{
            return 0;
        }
    }
    public function store(){
        return $this->belongsTo(StoreModal::class, 'store_id', 'id');
    }
}
