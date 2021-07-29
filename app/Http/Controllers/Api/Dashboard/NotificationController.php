<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class NotificationController extends Controller
{
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
        return $date->diffForHumans($this->getDateNow());
    }

    //
    public function getNotification()
    {
        $notification      = Notification::where([['action_user_id', '=', Auth::user()->id]])->with('user')->orderBy('created_at', 'desc')->get();
        $notifications_id  = $notification->map(function($data){
            $data["time"] = $this->formatDate($data->created_at);
            return $data->id;
        });
        Notification::whereIn('id',$notifications_id)->update(['status' => "seen"]);
        return ResponseHelper::handleRepsonse($notification);
    }
    public function getTotalNotification()
    {
        $notification = Notification::where([['action_user_id', '=', Auth::user()->id]])->count();
        return ResponseHelper::handleRepsonse(['total_notification'=>$notification]);
    }
}
