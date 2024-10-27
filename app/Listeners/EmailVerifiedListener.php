<?php

namespace App\Listeners;

use App\Enums\Metric;
use Illuminate\Auth\Events\Verified;

class EmailVerifiedListener
{
    public function __construct() {}

    public function handle(Verified $event): void
    {
        if ($event->user instanceof \App\Models\User) {
            $event->user->incrementMetric(Metric::EMAIL_VERIFIED);
        }
    }
}
