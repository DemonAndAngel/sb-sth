<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends BaseController
{
    public function lists(Request $request){
        $is_self = 0;
        $pageInfo = $this->getPageInfo('好文章，在这里','post');
        return view('post.lists',compact('pageInfo','is_self'));
    }
    public function edit(Request $request,$post_id=0)
    {
        $user = Auth::guard('web')->user();
        if(!empty($post_id)){
            $post = Post::where('id',$post_id)->first();
            if(empty($post))
                abort(404,'找不到文章');
            if($user->id != $post->user_id){
                abort(403,'权限不足');
            }
            $post_data = json_encode($post->toDetailData(),JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);
        }else{
            $post_data = json_encode([
                'id'=>0,
                'title'=>'',
                'content'=>'',
                'updated_at'=>'',
                'released_at'=>'',
            ],JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);
        }
        $pageInfo = $this->getPageInfo('自己的文章，自己做主','post');
        return view('post.edit',compact('pageInfo','post_data'));
    }
    public function detail(Request $request,$post_id){
        $post = Post::where('id',$post_id)->first();
        if(empty($post))
            abort(404,'找不到文章');
        $pageInfo = $this->getPageInfo($post->title,'post');
        $is_edit = 0;
        if(Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            if($user->id == $post->user_id){
                $is_edit = 1;
            }
        }
        $post_data = json_encode($post->toDetailData(),JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);
        return view('post.detail',compact('pageInfo','post_data','is_edit'));
    }
}
