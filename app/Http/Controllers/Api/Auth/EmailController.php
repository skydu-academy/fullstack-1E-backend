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
    private $url_email_redirect   = "http://localhost:3000/verify-email/";

    // Verification Email
    public function emailNotice()
    {
        return ResponseHelper::handleRepsonse(__('message.email_notice'), ResponseHelper::MESSAGE);
    }
    public function sendVerify($id, $hash)
    {
        return redirect()->away($this->url_email_redirect . "$id/$hash");
    }

    public function handleVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return ResponseHelper::handleRepsonse(__('message.email_verify_success'));
    }
    public function reSendEmailVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return ResponseHelper::handleRepsonse(__('message.verification_link_sent'));
    }
}
