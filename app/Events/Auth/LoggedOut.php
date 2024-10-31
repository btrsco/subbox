<?php

namespace App\Events\Auth;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class LoggedOut
{
    use Dispatchable;

    public function __construct(
        public User $user
    ) {}
}
