<?php

namespace App\Services;

use App\Events\Subscriptions\Subscribed;
use App\Models\User;

readonly class UserService extends Service
{
    public function __construct(
        public User $user
    ) {
        parent::__construct('user');
    }

    public function subscribeToBlog($blogId): bool
    {
        return $this->transact(function () use ($blogId) {
            $subscription = $this->user->subscriptions()->create([
                'blog_id' => $blogId,
            ]);

            event(new Subscribed($subscription));

            return true;
        });
    }
}
