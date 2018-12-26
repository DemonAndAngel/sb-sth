<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostDetail extends Model
{
    protected $table = 'post_details';
    public function post(){
        return $this->belongsTo(Post::class,'post_id','id');
    }
}
