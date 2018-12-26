<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $table = 'posts';
    protected $casts = [
        'is_draft' => 'boolean',
        'is_open' => 'boolean'
    ];
    protected $dates = [
        'deleted_at',
        'released_at'
    ];

    public function details()
    {
        return $this->hasMany(PostDetail::class, 'post_id', 'id');
    }

    public static function editPost($post,$user_id, $title, $content, $is_draft = true, $is_open = false)
    {
        $size = 1000;
        $total = Str::length($content);
        $totalPage = ceil($total / $size);
        if(empty($post)){
            $post = new Post();
        }
        $post->title = $title;
        $post->user_id = $user_id;
        $post->is_draft = $is_draft;
        $post->is_open = $is_open;
        $post->save();
        // 删除全部详情数据，重新存入
        $post->details()->delete();
        for ($page = 1; $page <= $totalPage; $page++) {
            $offset = $page * $size - $size;
            $tmpContent = Str::substr($content, $offset, $size);
            $postDetail = new PostDetail();
            $postDetail->page = $page;
            $postDetail->post_id = $post->id;
            $postDetail->content = $tmpContent;
            $postDetail->user_id = $user_id;
            $postDetail->save();
        }
        return $post;
    }

    public function toWebData()
    {
        $content = $this->details()->where('page',1)->first()->content;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $content,
        ];
    }
    public function toDetailData(){
        $details = $this->details()->orderBy('page')->get();
        $content = '';
        foreach ($details as $detail){
            $content.=$detail->content;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $content,
        ];
    }

    public function updatePostStatus($is_draft, $is_open, $is_release)
    {
        $this->is_draft = $is_draft;
        $this->is_open = $is_open;
        if ($is_release && empty($this->released_at)) {
            $this->released_at = Carbon::now();
        }
        $this->save();
        return $this;
    }
}
