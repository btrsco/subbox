<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    private array $observers = [
        \App\Models\Subscription::class => [
            \App\Observers\SubscriptionObserver::class
        ]
    ];

    public function register(): void {}

    public function boot(): void
    {
        foreach ($this->observers as $model => $observers) {
            foreach ($observers as $observer) {
                $model::observe($observer);
            }
        }
    }
}
