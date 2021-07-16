<?php

namespace App\Observers\Api\Dashboard;

use App\Models\Follower;
use App\Models\Notification;

class FollowerObserver
{
    public $afterCommit = true;
    /**
     * Handle the Follower "created" event.
     *
     * @param  \App\Models\Follower  $follower
     * @return void
     */
    public function created(Follower $follower)
    {
        //
        Notification::create([
            'user_notification_id' => $follower['user_follower_id'],
            'user_id'              => $follower['user_id'],
            'action'               => 'Follow',
            'status'               => 'waiting to be seen',
        ]);
    }

    /**
     * Handle the Follower "updated" event.
     *
     * @param  \App\Models\Follower  $follower
     * @return void
     */
    public function updated(Follower $follower)
    {
        //
    }

    /**
     * Handle the Follower "deleted" event.
     *
     * @param  \App\Models\Follower  $follower
     * @return void
     */
    public function deleted(Follower $follower)
    {
        //
    }

    /**
     * Handle the Follower "restored" event.
     *
     * @param  \App\Models\Follower  $follower
     * @return void
     */
    public function restored(Follower $follower)
    {
        //
    }

    /**
     * Handle the Follower "force deleted" event.
     *
     * @param  \App\Models\Follower  $follower
     * @return void
     */
    public function forceDeleted(Follower $follower)
    {
        //
    }
}
