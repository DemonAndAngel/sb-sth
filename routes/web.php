<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[
    'as'=>'index',
    'uses'=>'Web\PostController@lists'
]);

Route::get('/user/login',[
    'as'=>'user-login',
    'uses'=>'Web\UserController@login'
]);
Route::get('/user/register',[
    'as'=>'user-register',
    'uses'=>'Web\UserController@register'
]);


Route::get('/post',[
    'as'=>'post',
    'uses'=>'Web\PostController@lists'
]);

Route::get('/post/edit',[
    'as'=>'post-edit',
    'uses'=>'Web\PostController@edit'
])->middleware('auth:web');