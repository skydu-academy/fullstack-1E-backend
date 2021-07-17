<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class FollowerController extends Controller
{
    //
    public function follow(Request $request)
    {
        $user_id = Auth::user()->id;
        $follower_check = Follower::where([
            ['user_id', '=', $user_id],
            ['user_follower_id', '=', $request->user_follower_id],
        ])->first();
        if ($follower_check) {
            return ResponseHelper::handleRepsonse('user already follow', ResponseHelper::ERROR);
        }
        $user = User::find($user_id);
        $user->followers()->create([
            'user_follower_id'   => $request->user_follower_id,
            'status'             => 'waiting to confirmation',
        ]);
        return ResponseHelper::handleRepsonse('follow success');
    }

    public function unFollow($user_follower_id)
    {
        $id = Auth::user()->id;
        $follower = Follower::where([
            ['user_id', '=', $id],
            ['user_follower_id', '=', $user_follower_id],
        ])->first();
        if (is_null($follower)) {
            return ResponseHelper::handleRepsonse('unfollow failed because data not found', ResponseHelper::ERROR);
        }
         Follower::destroy($follower->id);
        return ResponseHelper::handleRepsonse('unfollow success');
    }

    public function checkFollowerById($user_follower_id)
    {
        $follower_check = Follower::where([
                    ['user_id', '=', Auth::user()->id],
                    ['user_follower_id', '=', $user_follower_id],
                ])->first();
    return ResponseHelper::handleRepsonse($follower_check ? true : false);
    }
}

