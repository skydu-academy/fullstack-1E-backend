<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class NotificationController extends Controller
{
    //
    public function getNotification()
    {
        $notification = Notification::where([['user_id', '=', Auth::user()->id]])->orderBy('created_at', 'desc')->get();
        return ResponseHelper::handleRepsonse($notification);
    }
    public function getTotalNotification()
    {
        $notification = Notification::where([['user_id', '=', Auth::user()->id]])->count();
        return ResponseHelper::handleRepsonse(['total_notification'=>$notification]);
    }
}
