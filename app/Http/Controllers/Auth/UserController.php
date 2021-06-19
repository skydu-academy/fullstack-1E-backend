<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\RegisterPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function registerEmail(RegisterPostRequest $request)
    {
        // validasi
        $data_user = $request->validated();
        $providers = 'email';
        return $this->registerWithEmail($data_user, $providers);
    }

    public function registerGoogleOrFb($providers, Request $request)
    {
        try {
            $requestProvider = Socialite::driver($providers)->userFromToken($request->token);
            return $this->registerWithGoogleOrFb($providers, $requestProvider, $request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


// Handle Function

    public function registerWithEmail($data_user, $providers)
    {
        $user = User::where(['email' => $data_user['email'], 'regis_with' => $providers])->first();
        if (!$user) {
            $user = new User;
            $user->email = $data_user['email'];
            $user->password = Hash::make($data_user['password']);
            $user->regis_with = $providers;
            $user->save();

            Auth::attempt(['email' => $data_user['email'], 'password' => $data_user['password']]);
            Auth::user()->sendEmailVerificationNotification();

            return response()->json(['success' => 'registration succes'], $this->successStatus);
        } else {
            return response()->json(['error' => 'User registered'], 401);
        }
    }
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
            $data_user                     = User::select('id','name', 'email')->where(['email' => $emailRequest, 'regis_with' => $providers])->first();
            $data_user['token']            = $data_user->createToken('My Token')->accessToken;
            $data_user['profil_picture']   = $requestProvider->avatar;
            Auth::loginUsingId($data_user->id);
            return response()->json(['success' => $data_user], $this->successStatus);
            // return response()->json(['success' => $data_user], $this->successStatus);
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
            $user = User::where(['email' => $emailRequest, 'regis_with' => $providers])->first();
            if (!$user) {
                $user                 = new User;
                $user->name           = $requestProvider->name;
                $user->email          = $requestProvider->email;
                $user->profil_picture = $requestProvider->avatar;
                $user->regis_with     = $providers;
                $user->save();

                $data_user = User::where(['email' => $emailRequest, 'regis_with' => $providers])->first();
                Auth::loginUsingId($data_user->id);
                Auth::user()->sendEmailVerificationNotification();
                Auth::logout();
                return response()->json(['success' => "register success"], $this->successStatus);

            } else {
                return $this->errorMessage();
            }
        } else {
            return $this->errorMessage();
        }
    }


    // Verification Email
    public function verify($id, $hash)
    {
        return redirect()->away("http://localhost:3000/$id/$hash");
    }

    public function handleVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return response()->json(['success' => 'Email Has Verify'], 401);
    }

    // Error Handle
    public function errorMessage()
    {
        return response()->json(['error' => 'Unauthorised'], 401);
    }
}
