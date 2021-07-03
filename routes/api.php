<?php

use App\Http\Controllers\Api\Auth\EmailController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
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
Route::post('register/{provider}', [RegisterController::class, 'registerGoogleOrFb']);
Route::post('register', [RegisterController::class, 'registerEmail']);

// Required Authentifikasi & Verification Email
Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::get('home',[HomeController::class, 'home']);
});

// Verification Email
Route::prefix('email')->middleware('auth:api')->group(function () {
    Route::get('/notice', [EmailController::class, 'emailNotice'])->name('verification.notice');
    Route::get('/resend-verify', [EmailController::class, 'reSendEmailVerification'])->name('verification.send');;
    Route::get('/handle-verify/{id}/{hash}', [EmailController::class, 'handleVerify']);
});
Route::get('/email/send-verify/{id}/{hash}', [EmailController::class, 'sendVerify'])->name('verification.verify');


Route::fallback(function () {
    return response()->json(['error' => 'Not Found!'], 404);
});
