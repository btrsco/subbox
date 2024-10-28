<?php

namespace App\Listeners;

use App\Enums\MetricKey;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetListener
{
    public function __construct() {}

    public function handle(PasswordReset $event): void
    {
        $event->user->incrementMetric(MetricKey::PASSWORD_RESET);
    }
}
