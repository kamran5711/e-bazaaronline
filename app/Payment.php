<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   protected $guarded=['id'];

   public static function getPayment($slug){
      // dd($slug);
      return Payment::with('payments')->where('slug',$slug)->first();
  } 
    public function orders(){
   return $this->hasMany('App\Models\Order');
}
}
