<?php

namespace App\Models;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'regis_with',
        'profil_picture'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'email_verified_at', 'created_at', 'updated_at', 'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function login($email, $login_with, $password = null){
        if($password){
            Auth::attempt(['email' => $email, 'password' => $password]);
            $data_user = Auth::user();
        }else{
            $data_user = $this->firstWhere([['email', '=', $email], ['regis_with', '=', $login_with]]);
            $data_user = $data_user ? Auth::loginUsingId($data_user->id) : false ;
        }
        return $data_user ? $data_user : false;
    }

    public function getDataLogin(){
        $data = Auth::user();
        $data['token'] = Auth::user()->createToken('My Token')->accessToken;
        return $data;
    }

    public function register($data_user){
        return event(new Registered($this->create($data_user)));
    }

    //Mutator
    public function setPasswordAttribute($value)
    {
        $this->password   = Hash::make($value);
    }
}
