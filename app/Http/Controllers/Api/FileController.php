<?php

namespace App\Http\Controllers\Api;

use App\Image;
use Illuminate\Http\Request;

class FileController extends BaseController
{
    public function uploadImg(Request $request){
        $type = $request->post('type','');
        if(!$request->hasFile('image')){
            return $this->makeResponseJson([],40003,'请选择图片上传');
        }
        switch ($type){
            case 'POST':
                $path = 'post/img';
                break;
            default:
                return $this->makeResponseJson([],40001,'暂不支持该类型');
                break;
        }
        $image = $request->file('image');
        $path = $image->store($path);
        // md/img/mfhEnxe2zGtOsB6b2eVWEOq2FeKL4Oyuc0NIqfIo.jpeg
        if(!$path){
            return $this->makeResponseJson([],40001,'上传图片错误');
        }
        $ext = $image->getClientOriginalExtension();
        $mime = $image->getMimeType();
        $driver = 'LOCAL';
        $image = Image::addImage($driver,$type,$path,$mime,$ext);
        $img_data = $image->image_data;
        return $this->makeResponseJson(compact('img_data'));
    }

}
