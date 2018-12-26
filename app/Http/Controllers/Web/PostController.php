<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends BaseController
{
    public function lists(Request $request){
        $pageInfo = $this->getPageInfo('好文章，在这里','post');
        return view('post.lists',compact('pageInfo'));
    }
    public function edit(Request $request){
        $pageInfo = $this->getPageInfo('自己的文章，自己做主','post');
        return view('post.edit',compact('pageInfo'));
    }
    public function detail(Request $request,$post_id){
        $post = Post::where('id',$post_id)->first();
        if(empty($post))
            abort(404,'找不到文章');
        $pageInfo = $this->getPageInfo($post->title,'post');
        $post_data = json_encode($post->toDetailData(),JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);
        return view('post.detail',compact('pageInfo','post_data'));
    }
}
