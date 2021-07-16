<?php

namespace App\Providers;

use App\Models\CommentPost;
use App\Models\Follower;
use App\Models\LikePost;
use App\Observers\Api\Dashboard\CommentPostObserver;
use App\Observers\Api\Dashboard\FollowerObserver;
use App\Observers\Api\Dashboard\LikePostObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        CommentPost::observe(CommentPostObserver::class);
        Follower::observe(FollowerObserver::class);
        LikePost::observe(LikePostObserver::class);
    }
}
