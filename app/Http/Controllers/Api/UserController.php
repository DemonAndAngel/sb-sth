<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        if($password.$salt != decrypt($user->password))
            return $this->makeResponseJson([],4003,'密码错误');
        Auth::guard('web')->login($user);
        $user = $user->toWebData();
        return $this->makeResponseJson(compact('user'));
    }
    public function logout(Request $request){
        Auth::guard('web')->logout();
        return $this->makeResponseJson();
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'account' => ['required'],
            'nickname'=>['required'],
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
        $nickname = $request->post('nickname');
        $password = $request->post('password');
        $user = User::where('account',$account)->first();
        if(!empty($user))
            return $this->makeResponseJson([],4004,'账号'.$account.'已注册');
        $user = User::createUser($account,$password,$nickname);
        Auth::guard('web')->login($user);
        $user = $user->toWebData();
        return $this->makeResponseJson(compact('user'));
    }
}
