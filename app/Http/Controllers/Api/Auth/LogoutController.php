<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    //
    public function logout(Request $request){

        $logout = $request->user()->token()->revoke();
        if($logout){
            return response()->json(['success' => 'Successfully logged out' ], 200);
        }
    }
}
