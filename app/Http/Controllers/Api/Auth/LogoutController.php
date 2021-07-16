<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ResponseHelper;

class LogoutController extends Controller
{
    //
    public function logout(Request $request){

    $request->user()->token()->revoke();
    return ResponseHelper::handleRepsonse(__('message.logout_success'));
    }
}
