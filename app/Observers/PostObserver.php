<?php

namespace App\Observers;

use App\Events\UpdatePostEvent;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        event(new UpdatePostEvent($post, 'create'));
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        event(new UpdatePostEvent($post, 'update'));
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        event(new UpdatePostEvent($post, 'delete'));
        // ехал медведь по лесу, видит машина горит, сел в нее и сгорел))0
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
