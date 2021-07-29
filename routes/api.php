<?php

use App\Http\Controllers\Api\Auth\EmailController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\ProfilController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Dashboard\CommentController;
use App\Http\Controllers\Api\Dashboard\HomeController;
use App\Http\Controllers\Api\Dashboard\PostController;
use App\Http\Controllers\Api\Dashboard\FollowerController;
use App\Http\Controllers\Api\Dashboard\LikedPostController;
use App\Http\Controllers\Api\Dashboard\LikePostController;
use App\Http\Controllers\Api\Dashboard\NotificationController;
use App\Models\Notification;
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
Route::get('dashboard/user',[UserController::class, 'getUserLogin'])->middleware('auth:api');
Route::prefix('dashboard')->middleware(['auth:api', 'verified'])->group(function () {
    // Dashboard
    Route::post('logout', [LogoutController::class, 'logout']);
    Route::get('home',[HomeController::class, 'home']);
    Route::apiResource('post', PostController::class);
    Route::post('post-update/{id}', [PostController::class,'updatePost']);

    Route::apiResource('comment-post', CommentController::class);
    Route::get('comment-post-id/{post_id}', [CommentController::class, 'commentByPostId']);
    Route::get('total-comment/{post_id}', [CommentController::class, 'totalComment']);
    //Profil
    Route::get('profil/{id}', [ProfilController::class, 'profil']);
    Route::get('profil-update/{id}', [ProfilController::class, 'show']);
    Route::post('profil-update/{id}', [ProfilController::class, 'update']);

    //FOllow
    Route::get('follow/{user_follower_id}', [FollowerController::class, 'checkFollowerById']);
    Route::post('follow', [FollowerController::class, 'follow']);
    Route::delete('unfollow/{user_follower_id}', [FollowerController::class, 'unFollow']);

    //Like
    Route::get('check-like', [LikePostController::class, 'checkLikePostById']);
    Route::get('total-like/{post_id}', [LikePostController::class, 'totalLike']);
    Route::post('like', [LikePostController::class, 'like']);
    Route::delete('unlike/{post_id}', [LikePostController::class, 'unLike']);

    Route::get('notification', [NotificationController::class, 'getNotification']);
    Route::get('total-notification', [NotificationController::class, 'getTotalNotification']);

});

// Verification Email
Route::prefix('email')->middleware('auth:api')->group(function () {
    Route::get('/notice', [EmailController::class, 'emailNotice'])->name('verification.notice');
    Route::get('/verify/{id}/{hash}', [EmailController::class, 'handleVerify']);
});
Route::get('/email/send-verify/{id}/{hash}', [EmailController::class, 'sendVerify'])->name('verification.verify');


Route::fallback(function () {
    return response()->json(['error' => 'Not Found!'], 404);
});
