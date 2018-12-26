<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/login',['as'=>'api:login','uses'=>'Api\UserController@login']);
Route::post('user/register',['as'=>'api:register','uses'=>'Api\UserController@register']);
Route::post('user/logout',['as'=>'api:logout','uses'=>'Api\UserController@logout']);

Route::post('file/upload/img',['as'=>'api:file-upload-img','uses'=>'Api\FileController@uploadImg']);


Route::get('post/get/list',['as'=>'api:post-get-list','uses'=>'Api\PostController@getList']);

Route::post('post/draft',['as'=>'api:post-draft','uses'=>'Api\PostController@draft'])->middleware('auth:web');
Route::post('post/release',['as'=>'api:post-release','uses'=>'Api\PostController@release'])->middleware('auth:web');
