<?php

namespace App\Observers\Api\Dashboard;

use App\Models\LikePost;
use App\Models\Notification;
use App\Models\Post;

class LikePostObserver
{
    public $afterCommit = true;
    /**
     * Handle the LikePost "created" event.
     *
     * @param  \App\Models\LikePost  $likedPost
     * @return void
     */
    public function created(LikePost $likedPost)
    {
        $post = Post::find($likedPost['post_id']);
        Notification::create([
            'user_notification_id' => $likedPost['user_id'],
            'user_id'              => $post->user_id,
            'action'               => 'like',
            'status'               => 'waiting to be seen',
        ]);
    }

    /**
     * Handle the LikePost "updated" event.
     *
     * @param  \App\Models\LikePost  $likedPost
     * @return void
     */
    public function updated(LikePost $likedPost)
    {
        //
    }

    /**
     * Handle the LikePost "deleted" event.
     *
     * @param  \App\Models\LikePost  $likedPost
     * @return void
     */
    public function deleted(LikePost $likedPost)
    {
        //
    }

    /**
     * Handle the LikePost "restored" event.
     *
     * @param  \App\Models\LikePost  $likedPost
     * @return void
     */
    public function restored(LikePost $likedPost)
    {
        //
    }

    /**
     * Handle the LikePost "force deleted" event.
     *
     * @param  \App\Models\LikePost  $likedPost
     * @return void
     */
    public function forceDeleted(LikePost $likedPost)
    {
        //
    }
}
