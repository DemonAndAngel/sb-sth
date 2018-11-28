<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected function makeResponseJson($data=[],$code=0,$msg='success',$red=''){
        $res = [
            'meta'=>[
                'code'=>$code,
                'msg'=>$msg,
            ],
            'data'=>$data
        ];
        if(!empty($red))
            $res['meta']['red'] = $red;
        return $res;
    }

    protected function makeResponseJsonWithPageInfo($pageInfo,$data=[],$code=0,$msg='success',$red=''){
        $res = [
            'meta'=>[
                'code'=>$code,
                'msg'=>$msg,
            ],
            'page_info'=>[
                'page'=>$pageInfo['page'],
                'size'=>$pageInfo['size'],
                'total'=>$pageInfo['total'],
                'total_page'=>ceil($pageInfo['total']/$pageInfo['size'])
            ],
            'data'=>$data
        ];
        if(!empty($red))
            $res['meta']['red'] = $red;
        exit(json_encode($res,JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE));
    }

    protected function makeResponseJsonToExit($data=[],$code=0,$msg='success',$red=''){
        $res = [
            'meta'=>[
                'code'=>$code,
                'msg'=>$msg,
            ],
            'data'=>$data
        ];
        if(!empty($red))
            $res['meta']['red'] = $red;
        exit(json_encode($res,JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE));
    }
}
