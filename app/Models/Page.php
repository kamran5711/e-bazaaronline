<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $primarykey = 'id';
    protected $fillable = ['title','content','type','user_id'];
}
