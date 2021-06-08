<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPostRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public $successStatus = 200;

    public function login(LoginPostRequest $request)
    {
        // validasi
        $data_user = $request->validated();
         return $this->AuthLogin($data_user);

    }

    public function AuthLogin($data_user){
        if (Auth::attempt($data_user)) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('My Token')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

}
