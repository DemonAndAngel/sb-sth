<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{

    public function getList(Request $request){
        $is_self = $request->get('is_self',0);
        if($is_self){
            if(!Auth::guard('web')->check())
                return $this->makeResponseJson([],403,'请登录');
        }
        $posts = Post::where('is_open',true)->where('is_draft',false)
            ->where(function ($q)use($is_self){
                if($is_self){
                    $q->where('user_id',Auth::guard('web')->user()->id);
                }
            })
            ->orderBy('released_at','desc')
            ->orderBy('updated_at','desc')
            ->get()->map(function ($item){
                return $item->toWebData();
            });
        return $this->makeResponseJson(compact('posts'));
    }
    public function draft(Request $request){
        $user = Auth::guard('web')->user();
        $validator = Validator::make($request->all(), [
            'post_id' => ['nullable','integer'],
            'title' => ['required','string'],
            'content' => ['required','string'],
        ],[
            'title.required'=>'文章标题不能为空',
            'content.required'=>'文章内容不能为空',
            'post_id.integer'=>'文章id必须为整型'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $msg = '';
            foreach ($errors as $error) {
                $msg = $error[0];
                break;
            }
            return $this->makeResponseJson([], 40003, $msg);
        }
        $post_id = $request->post('post_id');
        $title = $request->post('title');
        $content = $request->post('content');
        $user_id = $user->id;
        $post = null;
        if(!empty($post_id)){
            $post = $user->posts()->where('id',$post_id)->first();
            if(empty($post))
                return $this->makeResponseJson([],40004,'找不到文章');
        }
        $post = Post::editPost($post,$user_id,$title,$content);
        $post = $post->toWebData();
        return $this->makeResponseJson(compact('post'));
    }
    public function release(Request $request){
        $user = Auth::guard('web')->user();
        $validator = Validator::make($request->all(), [
            'post_id' => ['required','integer'],
        ],[
            'post_id.required'=>'文章id不能为空',
            'post_id.integer'=>'文章id必须为整型'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $msg = '';
            foreach ($errors as $error) {
                $msg = $error[0];
                break;
            }
            return $this->makeResponseJson([], 40003, $msg);
        }
        $post_id = $request->post('post_id');
        $post = $user->posts()->where('id',$post_id)->first();
        if(empty($post))
            return $this->makeResponseJson([],40004,'找不到文章');
        $post = $post->updatePostStatus(false,true,true);
        $post = $post->toWebData();
        return $this->makeResponseJson(compact('post'));
    }
}
