<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'image',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment_posts()
    {
        return $this->hasMany(CommentPost::class);
    }
    public function user_like_posts()
    {
        return $this->belongsToMany(User::class, 'like_posts')
            ->withTimestamps();
    }
    public function user_comment_posts()
    {
        return $this->belongsToMany(User::class, 'comment_posts')->withPivot('comment')
            ->withTimestamps();
    }
}
