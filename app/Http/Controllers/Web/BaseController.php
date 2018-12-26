<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected function getPageInfo($title,$activeName){
        $user = Auth::guard('web')->user();
        if($user)
            $user = $user->toWebData();
        return [
            'title'=>$title,
            'active_name'=>$activeName,
            'user_data'=> $user?json_encode($user,JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE):'{}',
        ];
    }
}
