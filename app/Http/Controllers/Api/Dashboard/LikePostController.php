<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\LikedPost;
use App\Models\LikePost;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class LikePostController extends Controller
{
    //
    public function like(Request $request)
    {
        $user_id    = Auth::user()->id;
        $post_id    = $request->post_id;
        $follower_check = LikePost::where([
            ['user_id', '=', $user_id],
            ['post_id', '=', $post_id],
        ])->first();

        if ($follower_check) {
            return ResponseHelper::handleRepsonse('post already like', ResponseHelper::ERROR);
        }

        $user = User::find($user_id);
        $user->post_like_users()->attach($post_id);

        Notification::create([
            'user_notification_id' => $user_id,
            'user_id'              => Auth::user(),
            'action_user_id'              => Auth::user(),
            'action_id'              => Auth::user(),
            'action'               => 'like',
            'status'               => 'waiting to be seen',
        ]);
        return ResponseHelper::handleRepsonse('like post success');
    }
    public function unLike($post_id)
    {
        $user_id = Auth::user()->id;
        $likedPost_data = LikePost::where([['user_id', '=', $user_id], ['post_id', '=', $post_id]])->first();
        if (is_null($likedPost_data)) {
            return ResponseHelper::handleRepsonse('Unliked post failed because data not found');
        }
        $user = User::find($user_id);
        $user->post_like_users()->detach($post_id);
        return ResponseHelper::handleRepsonse('unliked post success');
    }
    public function checkLikePostById($post_id)
    {
        $follower_check = LikePost::where([
            ['user_id', '=', Auth::user()->id],
            ['post_id', '=', $post_id],
        ])->first();
        return ResponseHelper::handleRepsonse($follower_check ? true : false);
    }
}
