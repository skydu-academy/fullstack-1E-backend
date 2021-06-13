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
    private $successStatus = 200;

    public function loginEmail(LoginPostRequest $request)
    {
        // validasi
        $data_user = $request->validated();
        return $this->loginWithEmail($data_user);
    }

    public function loginGoogleOrFb($providers, Request $request)
    {
        try {
            $requestProvider = Socialite::driver($providers)->userFromToken($request->token);
            return $this->loginWithGoogleOrFb($providers, $requestProvider, $request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    public function RegisterGoogleOrFb($providers, Request $request)
    {
        try {
            $requestProvider = Socialite::driver($providers)->userFromToken($request->token);
            return $this->registerWithGoogleOrFb($providers, $requestProvider, $request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    // Handle Function

    public function loginWithEmail($data_user)
    {
        if (Auth::attempt($data_user)) {
            $user = Auth::user();
            $data = [
                "name"  => $user->name,
                "email" => $user->email,
                "token" => $user->createToken('My Token')->accessToken
            ];

            return response()->json(['success' => $data], $this->successStatus);
        } else {
            return $this->errorMessage();
        }
    }

    public function loginWithGoogleOrFb($providers, $requestProvider, $request)
    {

        $emailProvider = $requestProvider->email;
        $emailRequest  = $request->email;

        // Compare Email Request with Email Google
        if ($emailRequest === $emailProvider) {
            $data_user                     = User::select('name', 'email')->where(['email' => $emailRequest, 'regis_with' => $providers])->first();
            $data_user['token']            = $data_user->createToken('My Token')->accessToken;
            $data_user['profil_picture']   = $requestProvider->avatar;
            Auth::login($data_user);
            return response()->json(['success' => $data_user], $this->successStatus);
        } else {
            return $this->errorMessage();
        }
    }

    public function registerWithGoogleOrFb($providers, $requestProvider, $request)
    {
        $emailProvider = $requestProvider->email;
        $emailRequest  = $request->email;

        // Compare Email Request with Email Google
        if ($emailRequest === $emailProvider) {
            $data_user = User::select('name', 'email')->where(['email' => $emailRequest, 'regis_with' => $providers])->first();
            if ($data_user) {
                $user                 = new User;
                $user->name           = $requestProvider->name;
                $user->email          = $requestProvider->email;
                $user->profil_picture = $requestProvider->avatar;
                $user->regis_with     = $providers;
                $user->save();
                return response()->json(['success' => "register success"], $this->successStatus);

            } else {
                return $this->errorMessage();
            }
        } else {
            return $this->errorMessage();
        }
    }

    public function errorMessage()
    {
        return response()->json(['error' => 'Unauthorised'], 401);
    }
}
