<?php

namespace App\Listeners;

use App\Enums\Metric;
use App\Events\Auth\LoggedOut;

class LoggedOutListener
{
    public function __construct() {}

    public function handle(LoggedOut $event): void
    {
        $event->user->incrementMetric(Metric::LOGOUT);
        $event->user->repository()->logLastActive();
    }
}
