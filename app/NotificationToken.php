<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationToken extends Model
{
    protected $table = 'notification_tokens';
    protected $fillable = ['user_id','token','server_key','device_id'];
}
