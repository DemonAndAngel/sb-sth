<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $rememberTokenName = '';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'name', 'email', 'password',
//    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
    public function posts(){
        return $this->hasMany(Post::class,'user_id','id');
    }
    public static function createUser($account,$password,$nickname){
        $salt = Str::random(10);
        $user = new User();
        $user->account = $account;
        $user->salt = $salt;
        $user->password = encrypt($password.$salt);
        $user->nickname = $nickname;
        $user->save();
        return $user;
    }
    public function toWebData(){
        return [
            'account'=>$this->account,
            'nickname'=>$this->nickname,
        ];
    }
}
