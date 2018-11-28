<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends BaseController
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => ['required'],
            'password' => ['required'],
        ], [
            'required' => '参数 :attribute 不能为空。',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $msg = '';
            foreach ($errors as $error) {
                $msg = $error[0];
                break;
            }
            return self::makeResponseJson([], 40002, $msg);
        }
        $account = $request->post('account');
        $password = $request->post('password');
        $user = User::where('account',$account)->first();
        if(empty($user))
            return $this->makeResponseJson([],4004,'账号'.$account.'未注册');
        $salt = $user->salt;
        $password = encrypt($password.$salt);
        if($user->password != $password)
            return $this->makeResponseJson([],4003,'密码错误');
        $token = Auth::guard('jwt')->login($user);
        return $this->makeResponseJson(compact('token'));
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => ['required'],
            'password' => ['required'],
        ], [
            'required' => '参数 :attribute 不能为空。',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $msg = '';
            foreach ($errors as $error) {
                $msg = $error[0];
                break;
            }
            return self::makeResponseJson([], 40002, $msg);
        }
        $account = $request->post('account');
        $password = $request->post('password');
        $user = User::where('account',$account)->first();
        if(!empty($user))
            return $this->makeResponseJson([],4004,'账号'.$account.'已注册');
        $salt = Str::random(10);
        $user = new User();
        $user->account = $account;
        $user->salt = $salt;
        $user->password = encrypt($password.$salt);
        $user->save();
        $token = Auth::guard('jwt')->login($user);
        return $this->makeResponseJson(compact('token'));
    }
}
