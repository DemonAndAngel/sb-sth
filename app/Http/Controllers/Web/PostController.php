<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Web\BaseController;
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
}
