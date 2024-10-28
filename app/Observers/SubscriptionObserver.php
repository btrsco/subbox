<?php

namespace App\Observers;

use App\Models\Subscription;

class SubscriptionObserver
{
    public function creating(Subscription $subscription): void
    {
        $subscription->verification_token = str()->random(60);
    }
}
