<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class HomeController extends Controller
{
    //
    public function home(){
        return ResponseHelper::handleRepsonse(Auth::user());
    }
}
