<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


class UserController extends Controller
{
    //
    public $successStatus = 200;

    public function login(LoginPostRequest $request)
    {
        // validasi
        $data_user = $request->validated();
        return $this->loginWithEmail($data_user);

    }

    public function loginWithEmail($data_user){
        if (Auth::attempt($data_user)) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('My Token')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function loginGoogle(Request $request){
    try {
        // cek token in google valid or not
        $googleRequest= Socialite::driver('google')->userFromToken($request->googleToken);
        return $this->loginWithGoogle($request, $googleRequest);
    } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function loginWithGoogle($request, $googleRequest){
        $emailGoogle  = $googleRequest->email;
        $emailRequest = $request->email;
        if ($emailRequest === $emailGoogle) {
            $data = [
                "name"      => $googleRequest->name,
                "email"     => $emailGoogle,
                "picture"   => $googleRequest->avatar,
            ];
            return response()->json(['success' => $data], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
