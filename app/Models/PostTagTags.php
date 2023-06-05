<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTagTags extends Model
{
    public $timestamps = false;
    // protected $table = 'post_tag_tags';
    protected $guarded = [];

    public function post(){
        return $this->belongsTo(Post::class);
    }
    public function tag(){
        return $this->belongsTo(PostTag::class, 'post_tag_id', 'id');
    }
}
