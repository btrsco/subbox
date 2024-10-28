<?php

namespace App\Listeners;

use App\Enums\MetricKey;
use App\Events\Auth\LoggedIn;

class LoggedInListener
{
    public function __construct() {}

    public function handle(LoggedIn $event): void
    {
        $event->user->incrementMetric(MetricKey::LOGIN);
    }
}
