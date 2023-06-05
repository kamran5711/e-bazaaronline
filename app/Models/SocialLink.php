<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialLink extends Model
{
    protected $primarykey = 'id';
    protected $table = 'social_links';
    protected $guarded = [];
    use SoftDeletes;
    public function store()
    {
        return $this->belongsTo('App\Models\Store','store_id');
    }
}
