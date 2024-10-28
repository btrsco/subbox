<?php

namespace App\Events\Subscriptions;

use App\Models\Subscription;
use Illuminate\Foundation\Events\Dispatchable;

class Subscribed
{
    use Dispatchable;

    public function __construct(
        public Subscription $subscription
    ) {
        // ...
    }
}
