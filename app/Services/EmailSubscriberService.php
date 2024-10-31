<?php

namespace App\Services;

use App\Events\Subscriptions\Subscribed;
use App\Models\EmailSubscriber;
use App\Models\User;

readonly class EmailSubscriberService extends Service
{
    public function __construct(
        public EmailSubscriber $emailSubscriber
    ) {
        parent::__construct('emailSubscriber');
    }

    public function subscribeToBlog($blogId): bool
    {
        return $this->transact(function () use ($blogId) {
            $subscription = $this->emailSubscriber->subscriptions()->create([
                'blog_id' => $blogId,
            ]);

            event(new Subscribed($subscription));

            return true;
        });
    }
}
