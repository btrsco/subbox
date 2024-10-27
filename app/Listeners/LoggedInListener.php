<?php

namespace App\Listeners;

use App\Enums\Metric;
use App\Events\Auth\LoggedIn;

class LoggedInListener
{
    public function __construct() {}

    public function handle(LoggedIn $event): void
    {
        $event->user->incrementMetric(Metric::LOGIN);
        $event->user->repository()->logLastLoggedIn();
    }
}
