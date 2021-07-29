<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CommentPost;
use App\Models\LikePost;
use App\Models\Notification;
use App\Models\Post;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class HomeController extends Controller
{
    //
    private $today                = 'Today';
    private $format_date_complete = 'MMMM YY, HH:MM A';
    private $format_date_Time     = 'HH:MM A';

    public function getDateNow(){
        $datetime = new DateTime();
        $timezone = new DateTimeZone('Asia/Jakarta');
        $datetime->setTimezone($timezone);
        return $datetime;
    }
    public function formatDate($date){
        if ($date->diffInDays($this->getDateNow()) === 0) {
            return $this->today.', '.$date->isoFormat($this->format_date_Time);
        }
        return $date->isoFormat($this->format_date_complete);
    }

    public function home(){
        // Carbon::setLocale('id');

        // $post = Post::with('user')->whereIn('user_id',[1,3,4])->orderBy('created_at','desc')->get();
        $post                       = Post::with('user')->orderBy('created_at', 'desc')->get();
        $data_post                  = $post->map(function ($post) {
            $data['id']             = $post->id;
            $data['caption']        = $post->caption;
            $data['image']          = $post->image;
            $data['user']           = $post->user;
            $data['total_like']     = LikePost::where('post_id', $post->id)->count();
            $data['total_comment']  = CommentPost::where('post_id', $post->id)->count();
            $data['created_at']     = $this->formatDate($post->created_at);
            return $data;
        });
        $data['profil_picture']     = Auth::user()->profil_picture;
        $data['regis_with']         = Auth::user()->regis_with;
        $data['user_auth_id']       = Auth::user()->id;
        $data['name']               = Auth::user()->name;
        $data['total_notification'] = Notification::whereIn('action_user_id',[Auth::user()->id])->where([['status', '=', 'waiting to be seen' ]])->count();
        $data['posts']              = $data_post;
        $like_posts_id              = LikePost::whereIn('user_id',[Auth::user()->id])->get(['post_id']);
        $data['like_posts_id'] = $like_posts_id->map(function ($data) {
            return $data = $data->post_id;
        });

        return ResponseHelper::handleRepsonse($data);
    }
}
