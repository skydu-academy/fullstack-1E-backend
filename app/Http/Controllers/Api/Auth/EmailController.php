<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerifyRequest;
use Exception;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use ResponseHelper;

class EmailController extends Controller
{
    private $url_email_redirect   = "http://localhost:3000/";

    // Verification Email
    public function emailNotice()
    {
        return ResponseHelper::handleRepsonse(__('message.email_notice'), ResponseHelper::MESSAGE);
    }
    public function sendVerify($id, $hash)
    {
        return redirect()->away($this->url_email_redirect . "$id/$hash");
    }

    public function handleVerify($id, $hash)
    {
        return $this->checkUserLoginWithEmailData($id, $hash);
        $user_check_email   = auth()->user()->hasVerifiedEmail();
        $message            =  $user_check_email ? __('message.email_has_been_verify') : $this->emailVerifySuccess($request);
        return ResponseHelper::handleRepsonse($message);
    }
    public function reSendEmailVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return ResponseHelper::handleRepsonse(__('message.verification_link_sent'));
    }

/*
   Fragment Method
*/
    private function checkUserLoginWithEmailData($id, $hash){
        $id     = !hash_equals((string) $id, (string) Auth::user()->id);
        $hash   = !hash_equals((string) $hash, sha1(Auth::user()->email));
        if ($id || $hash) return ResponseHelper::handleRepsonse(__('message.unauthorised'), ResponseHelper::UNAUTHENTICATED);
    }
    private function emailVerifySuccess(EmailVerifyRequest $request){
        $request->fulfill();
        return __('message.email_verify_success');
    }
}
