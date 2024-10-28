<?php

namespace App\Listeners;

use App\Events\Subscriptions\Subscribed;
use App\Notifications\BlogSubscriptionOptInNotification;

class SubscribedToBlogListener
{
    public function __construct() {}

    public function handle(Subscribed $event): void
    {
        $subscriber = $event->subscription->subscriber;

        $subscriber->notify(new BlogSubscriptionOptInNotification($event->subscription));
    }
}
