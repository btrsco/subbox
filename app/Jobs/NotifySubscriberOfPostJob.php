<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\Subscription;
use App\Notifications\PostPublishedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifySubscriberOfPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Subscription $subscription,
        public Post $post
    ) {}

    public function handle(): void
    {
        if ( ! $this->post->published_at) {
            return;
        }

        if ($this->post->published_at->isFuture()) {
            NotifySubscriberOfPostJob::dispatch($this->subscription, $this->post)
                ->delay($this->post->published_at);

            return;
        }

        if ( Subscription::find($this->subscription->id)->withoutTrashed()->doesntExist() ) {
            return;
        }

        $subscriber = $this->subscription->subscriber;
        $subscriber->notify(new PostPublishedNotification($this->post));
    }
}
