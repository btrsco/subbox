<?php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver
{
    public function creating(Subscription $subscription): void
    {
        $subscription->verification_token = md5(
            $subscription->subscriber_id.':'
            .$subscription->subscriber_type.':'
            .$subscription->blog_id
        );
    }
}
