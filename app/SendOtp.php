<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendOtp extends Model
{
    protected $table = 'send_otps';
    protected $fillable = ['email','mobile_no','email','is_verified','otp','created_at','updated_at'];

}
