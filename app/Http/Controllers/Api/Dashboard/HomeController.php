<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CommentPost;
use App\Models\LikePost;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class HomeController extends Controller
{
    //
    public function home(){
        // $post = Post::with('user')->whereIn('user_id',[1,3,4])->orderBy('created_at','desc')->get();
        $post                       = Post::with('user')->orderBy('created_at', 'desc')->get();
        $data_post                  = $post->map(function ($post) {
            $data['id']             = $post->id;
            $data['caption']        = $post->caption;
            $data['image']          = $post->image;
            $data['user']           = $post->user;
            $data['total_like']     = LikePost::where('post_id', $post->id)->count();
            $data['total_comment']  = CommentPost::where('post_id', $post->id)->count();
            return $data;
        });
        $data['profil_picture']     = Auth::user()->profil_picture;
        $data['regis_with']         = Auth::user()->regis_with;
        $data['total_notification'] = Notification::where([['action_user_id', '=', Auth::user()->id]])->count();
        $data['posts']              = $data_post;
        return ResponseHelper::handleRepsonse($data);
    }
}
