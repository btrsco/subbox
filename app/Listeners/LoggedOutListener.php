<?php

namespace App\Listeners;

use App\Enums\MetricKey;
use App\Events\Auth\LoggedOut;

class LoggedOutListener
{
    public function __construct() {}

    public function handle(LoggedOut $event): void
    {
        $event->user->incrementMetric(MetricKey::LOGOUT);
    }
}
