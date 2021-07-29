<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class UserController extends Controller
{
    //
    public function getUserLogin()
    {
        return ResponseHelper::handleRepsonse(Auth::user());
    }
}
