<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $table = 'images';
    public static function addImage($driver,$type,$path,$mime,$ext){
        $image = new Image();
        $image->mime = $mime;
        $image->ext = $ext;
        $image->path = $path;
        $image->driver = $driver;
        $image->type = $type;
        $image->save();
        return $image;
    }
    public function getImageDataAttribute(){
        $url = '';
        switch ($this->driver){
            case 'LOCAL':
                $url = Storage::url($this->path);
                break;
        }
        return [
            'id'=>$this->id,
            'url'=>$url,
        ];
    }
}
