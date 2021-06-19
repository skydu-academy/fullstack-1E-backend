<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentifikasi
Route::post('login', [UserController::class, 'loginEmail']);
Route::post('login/{providers}', [UserController::class, 'loginGoogleOrFb']);
Route::post('register/{providers}', [UserController::class, 'registerGoogleOrFb']);
Route::post('register', [UserController::class, 'registerEmail']);

// Wajib Authentifikasi
Route::middleware(['auth:api'])->group(function () {
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::get('home',[HomeController::class, 'home']);
});

// Verifikasi Email
Route::prefix('email')->group(function(){
    Route::get('/verify/{id}/{hash}', [UserController::class, 'verify'])->name('verification.verify');
    Route::get('/handle-verify/{id}/{hash}', [UserController::class, 'handleVerify'])
    ->middleware(['auth:api']);
});



