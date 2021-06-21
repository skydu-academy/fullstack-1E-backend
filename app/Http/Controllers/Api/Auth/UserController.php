<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPostRequest;
use App\Http\Requests\Auth\RegisterPostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Laravel\Socialite\Facades\Socialite;
use ResponseHelper;

class UserController extends Controller
{
    private $data_user_from_provider;
    private $url_email_redirect   = "http://localhost:3000/";
    private $email_message_verify = "Email Has Verify";

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //LOGIN
    public function loginEmail(LoginPostRequest $request)
    {
        if ($this->user->login($request->email, 'email', $request->password)) {
            return ResponseHelper::handleRepsonse($this->user->getDataLogin());
        }
        return ResponseHelper::handleRepsonse(__('message.unauthorised'), ResponseHelper::ERROR);
    }

    public function loginGoogleOrFb(Request $request, $provider)
    {
        $provider_check   = $this->checkTokenProvider($request, $provider);
        $db_check_user    = $this->user->login($this->data_user_from_provider['email'] ?? '' , $provider);
        if($provider_check && $db_check_user){
            return ResponseHelper::handleRepsonse($this->user->getDataLogin());
        }
        return ResponseHelper::handleRepsonse(__('message.unauthorised'), ResponseHelper::ERROR);

    }

    //REGISTER
    public function registerEmail(RegisterPostRequest $request)
    {
        $data_user          = $request->validated();
        $db_check_user      = $this->user->login($request->email, 'email');
        if (!$db_check_user) {
            $data_user['regis_with'] = 'email';
            $this->user->register($data_user);
            return ResponseHelper::handleRepsonse(__('message.user_register'));
        }
       return ResponseHelper::handleRepsonse(__('message.user_registered'), ResponseHelper::ERROR);
    }

    public function registerGoogleOrFb($provider, Request $request)
    {
        $provider_check = $this->checkTokenProvider($request, $provider);
        $db_check       = $this->user->login( $this->data_user_from_provider['email'] , $provider);

        if ($provider_check && !$db_check) {
            $this->user->register($this->data_user_from_provider);
            return ResponseHelper::handleRepsonse(__('message.user_register'));
        }
       return ResponseHelper::handleRepsonse(__('message.user_registered'), ResponseHelper::ERROR);
    }

    // Verification Email
    public function verify($id, $hash)
    {
        return redirect()->away($this->url_email_redirect."$id/$hash");
    }

    public function handleVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return ResponseHelper::handleRepsonse($this->email_message_verify);
    }

    // Check Authentifikasi Token Google And Facebook
    public function checkTokenProvider($request, $provider){
        try {
            $request_provider = Socialite::driver($provider)->userFromToken($request->token);
            $token            = false;
                if ($request->email === $request_provider->email) {
                    $this->data_user_from_provider = $this->getDataProvider($request_provider, $provider);
                    $token =  true;
                }
            return $token;
        } catch (Exception $e) {
            return ResponseHelper::handleRepsonse($e->getMessage(), ResponseHelper::ERROR);
        }
    }

    public function getDataProvider($data, $provider){
        return [
            'name'          => $data->name,
            'email'         => $data->email,
            'profil_picture' => $data->avatar,
            'regis_with'    => $provider,
        ];
    }
}
