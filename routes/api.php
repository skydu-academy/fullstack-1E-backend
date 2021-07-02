<?php

use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Dashboard\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentifikasi
Route::post('register/{provider}', [UserController::class, 'registerGoogleOrFb']);
Route::post('register', [UserController::class, 'registerEmail']);

// Route::post('login', function(){
//     $response = Http::asForm()->post('http://passport-app.com/oauth/token', [
//         'grant_type' => 'password',
//         'client_id' => '1',
//         'client_secret' => 'eahf87pQUpE1PODPXmGpWTEwjLv934RqqMdRhaVR',
//         'username' => 'user@gmail.com',
//         'password' => 'user123456',
//         'scope' => '',
//     ]);

//     return ResponseHelper::handleRepsonse($response->json());
// });

// Required Authentifikasi & Verification Email
Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::get('home',[HomeController::class, 'home']);
});

// Verification Email
Route::prefix('email')->middleware(['auth:api'])->group(function () {
    Route::get('/verify-notice', [UserController::class, 'verifyNotice'])->name('verification.notice');
    Route::get('/send-verify/{id}/{hash}', [UserController::class, 'sendVerify'])->name('verification.verify');
    Route::get('/resend-verify', [UserController::class, 'reSendEmailVerification'])->name('verification.send');;
    Route::get('/handle-verify/{id}/{hash}', [UserController::class, 'handleVerify']);
});



