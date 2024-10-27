<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogLastActive
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guest()) {
            return $next($request);
        }

        $user         = auth()->user();
        $shouldUpdate = $user->last_active_at === null || $user->last_active_at->diffInMinutes(now()) >= 5;

        if ($shouldUpdate) {
            $user->repository()->logLastActive();
        }

        return $next($request);
    }
}
