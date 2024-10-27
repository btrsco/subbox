<?php

namespace App\Listeners;

use App\Enums\Metric;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetListener
{
    public function __construct() {}

    public function handle(PasswordReset $event): void
    {
        $event->user->incrementMetric(Metric::PASSWORD_RESET);
    }
}
