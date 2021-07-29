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
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $today                = 'Today';
    private $format_date_complete = 'MMMM YY, HH:MM A';
    private $format_date_Time     = 'HH:MM A';

    public function getDateNow()
    {
        $datetime = new DateTime();
        $timezone = new DateTimeZone('Asia/Jakarta');
        $datetime->setTimezone($timezone);
        return $datetime;
    }
    public function formatDate($date)
    {
        if ($date->diffInDays($this->getDateNow()) === 0) {
            return $this->today . ', ' . $date->isoFormat($this->format_date_Time);
        }
        return $date->isoFormat($this->format_date_complete);
        return $date->isoFormat($this->format_date_complete);
    }

    public function profil($id)
    {
        $user                           = User::find($id);
        $data['user_auth_id']           = Auth::user()->id;
        $data['total_followers']        = Follower::where('user_follower_id', $id)->count();
        $data['total_following']        = Follower::where('user_id', $id)->count();
        $data['total_notification'] = Notification::whereIn('action_user_id', [Auth::user()->id])->where([['status', '=', 'waiting to be seen']])->count();
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
            $data['created_at']     = $this->formatDate($post->created_at);
            return $data;
        });
        $like_posts_id    = LikePost::whereIn('user_id', [Auth::user()->id])->get(['post_id']);
        $data['like_posts_id'] = $like_posts_id->map(function ($data) {
            return $data = $data->post_id;
        });
        $data['total_posts']            = $data['posts']->count();

        // $data['posts']['total_likes']   = LikePost::where('user_id',$id)->count();

        return ResponseHelper::handleRepsonse(array_merge($data, $user->toArray()));
        // return ResponseHelper::handleRepsonse();
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
        $request->validated();
        // return ResponseHelper::handleRepsonse($request->file('image')->getClientOriginalExtension());
        $user                   = User::select('profil_picture', 'name', 'email', 'deskripsi')->find($id);
        $image                  = $request->file('image');
        $file_name              = !isset($image) ?: md5('skybook' . time()) . "." . $image->getClientOriginalExtension();
        $user['name']           = $user->name === $request->name ? $user->name : $request->name;
        $user['email']          = $user->email === $request->email ? $user->email : $request->email;
        $user['profil_picture'] = isset($image) ? $file_name : $user->profil_picture;
        $user['deskripsi']      = empty($request->deskripsi)  ?  NULL : $request->deskripsi;
        // return ResponseHelper::handleRepsonse($request->image->getClientOriginalName());
        // return ResponseHelper::handleRepsonse($request->deskripsi);
        User::where('id', $id)->update( $user->toArray()  );
        !isset($image) ?: $image->storeAs('public/posts', $file_name);
        return ResponseHelper::handleRepsonse(__('message.updated_user_success'));
    }

}
