<?php

namespace App\Listeners;

use App\Events\Posts\Published;
use App\Jobs\NotifySubscriberOfPostJob;

class PostPublishedListener
{
    public function __construct() {}

    public function handle(Published $event): void
    {
        if ( ! $event->post->published_at) {
            return;
        }

        $blog          = $event->post->blog;
        $subscriptions = $blog->subscriptions()->with('subscriber')->get();

        foreach ($subscriptions as $subscription) {
            $scheduledAt = $event->post->published_at->isFuture()
                ? $event->post->published_at
                : now();

            NotifySubscriberOfPostJob::dispatch($subscription, $event->post)
                ->delay($scheduledAt);
        }
    }
}
