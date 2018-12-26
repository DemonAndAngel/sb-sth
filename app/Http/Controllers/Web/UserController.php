<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends BaseController
{
    public function login(Request $request){
        $url = $request->get('url','');
        $pageInfo = $this->getPageInfo('马上登录','user');
        return view('user.login',compact('pageInfo','url'));
    }
    public function register(Request $request){
        $url = $request->get('url','');
        $pageInfo = $this->getPageInfo('立即注册','user');
        return view('user.register',compact('pageInfo','url'));
    }
}
