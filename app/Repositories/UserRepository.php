<?php

namespace App\Repositories;

use App\Models\User;

readonly class UserRepository extends Repository
{
    public function __construct(
        public User $user
    ) {}

    public function logLastActive(): bool
    {
        return $this->transact(function () {
            $this->user->update([
                'last_active_at' => now(),
            ]);
        });
    }

    public function logLastLoggedIn(): bool
    {
        return $this->transact(function () {
            $this->user->update([
                'last_logged_in_at' => now(),
                'last_active_at'    => now(),
            ]);
        });
    }
}
