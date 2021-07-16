<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use ResponseHelper;

class RegisterController extends Controller
{
    private $data_user_from_provider;
    const EMAIL      = 'email';
    const REGIS_WITH = 'regis_with';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //REGISTER
    public function registerEmail(RegisterPostRequest $request)
    {
        $data_user          = $request->validated();
        $db_check_user      = $this->user->checkUser($request->email, self::EMAIL);

        // return ResponseHelper::handleRepsonse($db_check_user);
        if ($db_check_user) {
            return ResponseHelper::handleRepsonse(__('message.user_registered'), ResponseHelper::ERROR);
        }
        $data_user[self::REGIS_WITH] = self::EMAIL;
        event(new Registered($this->user->register($data_user)));
        return ResponseHelper::handleRepsonse(__('message.user_register_success'));
    }

    public function registerGoogleOrFb($provider, Request $request)
    {
       $checkProvider =  $this->checkTokenProvider($request, $provider);
       // valid when have error in provider
       if($checkProvider){
           return ResponseHelper::handleRepsonse($checkProvider, ResponseHelper::ERROR);
        }

        $email              = $this->data_user_from_provider[self::EMAIL];
        $db_check_user      = $this->user->checkUser($email, $provider);

        // valid When User Registered
        if (!$db_check_user) {
            return ResponseHelper::handleRepsonse(__('message.user_registered'), ResponseHelper::ERROR);
        }
        $this->user->register($this->data_user_from_provider);
        return ResponseHelper::handleRepsonse(__('message.user_register'));
    }

    // Check Authentifikasi Token Google And Facebook
    public function checkTokenProvider($request, $provider){
        try {
            $request_provider = Socialite::driver($provider)->userFromToken($request->token);
                if ($request->email === $request_provider->email) {
                    $this->data_user_from_provider = $this->getDataProvider($request_provider, $provider);
                    return false;
                }
                return __('message.email_not_same');
        } catch (Exception $e) {
            return __('message.token_invalid');
        }
    }

    public function getDataProvider($data, $provider){
        return [
            'name'               => $data->name,
            'email'              => $data->email,
            'profil_picture'     => $data->avatar,
            'password'           => $data->id,
            'regis_with'         => $provider,
            'email_verified_at'  => now(),
        ];
    }
}
