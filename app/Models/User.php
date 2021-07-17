<?php

namespace App\Models;

use App\Http\Requests\Auth\LoginPostRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use ResponseHelper;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'regis_with',
        'profil_picture',
        'email_verified_at',
        'deskripsi'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'created_at', 'updated_at', 'email_verified_at',
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checkUser($email, $login_with)
    {
        return $this->firstWhere([['email', '=', $email], ['regis_with', '=', $login_with]]);
    }

    public function register($data_user){
        $data_user['password']          = Hash::make($data_user['password']);
        return $this->create($data_user);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function followers(){
        return $this->hasMany(Follower::class);
    }
    public function notifications(){
        return $this->hasMany(Notification::class);
    }
    public function post_like_users(){
        return $this->belongsToMany(Post::class, 'like_posts')
                    ->withTimestamps();
    }
    public function post_comment_users(){
        return $this->belongsToMany(Post::class, 'comment_posts')->withPivot('comment')
                    ->withTimestamps();
    }

}
