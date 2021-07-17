<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilRequest;
use App\Models\CommentPost;
use App\Models\Follower;
use App\Models\LikePost;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profil($id)
    {
        $user                           = User::find($id);
        $data['id']                     = $user->id;
        $data['name']                   = $user->name;
        $data['profil_picture']         = $user->profil_picture;
        $data['deskripsi']              = $user->deskripsi;
        $data['regis_with']             = $user->regis_with;
        $data['total_posts']            = Post::where('user_id', $id)->count();
        $data['total_followers']        = Follower::where('user_follower_id', $id)->count();
        $data['total_following']        = Follower::where('user_id', $id)->count();
        $data['total_notification']     = Notification::where([['action_user_id', '=', Auth::user()->id]])->count();
        $post                           = Post::where('user_id',$id)->with('user')->orderBy('created_at', 'desc')->get();
        $data['posts']                  = $post->map(function($post){
            $data['id']             = $post->id;
            $data['caption']        = $post->caption;
            $data['image']          = $post->image;
            $data['user']           = $post->user;
            $data['user']           = $post->user;
            $data['total_like']     = LikePost::where('post_id', $post->id)->count();
            $data['total_comment']  = CommentPost::where('post_id', $post->id)->count();
            $data['total_comment']  = CommentPost::where('post_id', $post->id)->count();
            return $data;
        });

        // $data['posts']['total_likes']   = LikePost::where('user_id',$id)->count();

        return ResponseHelper::handleRepsonse($data);
    }

    // For Get data update with Id
    public function show($id)
    {
        if(Auth::user()->id === (int) $id){
            $data = User::select('profil_picture', 'name', 'email', 'deskripsi')->find($id);
            return ResponseHelper::handleRepsonse($data);
        }else{
            return ResponseHelper::handleRepsonse(__('message.unauthenticated'),ResponseHelper::ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfilRequest $request, $id)
    {
        $user                   = User::select('profil_picture', 'name', 'email', 'deskripsi')->find($id);
        $image                  = $request->image;
        $file_name              = !isset($image) ?: md5('skybook' . time()) . "." . $image->getClientOriginalExtension();
        $user['name']           = $user->name === $request->name ? $user->name : $request->name;
        $user['email']          = $user->email === $request->email ? $user->email : $request->email;
        $user['profil_picture'] = isset($image) ? $file_name : $user->profil_picture;
        $user['deskripsi']      = $request->deskripsi ?? $user->deskripsi;
        User::where('id', $id)->update($user->toArray());
        !isset($image) ?: $image->storeAs('public/posts', $file_name);
        return ResponseHelper::handleRepsonse(__('message.updated_user_success'));
    }

}
