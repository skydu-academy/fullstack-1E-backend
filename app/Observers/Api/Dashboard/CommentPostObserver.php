<?php

namespace App\Observers\Api\Dashboard;

use App\Models\CommentPost;
use App\Models\Notification;
use App\Models\Post;

class CommentPostObserver
{
    public $afterCommit = true;
    /**
     * Handle the CommentPost "created" event.
     *
     * @param  \App\Models\CommentPost  $commentPost
     * @return void
     */
    public function created(CommentPost $commentPost)
    {
        //
        $post = Post::find($commentPost['post_id']);
        Notification::create([
            'user_notification_id' => $commentPost['user_id'],
            'user_id'              => $post->user_id,
            'action'               => 'comment',
            'status'               => 'waiting to be seen',
        ]);
    }

    /**
     * Handle the CommentPost "updated" event.
     *
     * @param  \App\Models\CommentPost  $commentPost
     * @return void
     */
    public function updated(CommentPost $commentPost)
    {
        //
    }

    /**
     * Handle the CommentPost "deleted" event.
     *
     * @param  \App\Models\CommentPost  $commentPost
     * @return void
     */
    public function deleted(CommentPost $commentPost)
    {
        //
    }

    /**
     * Handle the CommentPost "restored" event.
     *
     * @param  \App\Models\CommentPost  $commentPost
     * @return void
     */
    public function restored(CommentPost $commentPost)
    {
        //
    }

    /**
     * Handle the CommentPost "force deleted" event.
     *
     * @param  \App\Models\CommentPost  $commentPost
     * @return void
     */
    public function forceDeleted(CommentPost $commentPost)
    {
        //
    }
}
