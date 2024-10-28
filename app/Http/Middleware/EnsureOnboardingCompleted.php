<?php

namespace App\Http\Middleware;

use App\Enums\MetricKey;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EnsureOnboardingCompleted
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        // Check if the route has the 'auth' middleware
        if ( ! $route || ! in_array('auth', $route->middleware())) {
            return $next($request);
        }

        // Skip the middleware if the user is not authenticated or if the route is part of the onboarding process
        if ( ! auth()->check() || str_starts_with($route->getName(), 'onboarding.')) {
            return $next($request);
        }

        // Check if user has a blog and assume the onboarding process is completed
        if (auth()->user()->blog()->exists()) {
            return $next($request);
        }

        // Redirect the user to the onboarding process if it's not completed
        if ( ! $this->userIsOnboarded(auth()->user())) {
            return redirect()->route('onboarding.blog');
        }

        return $next($request);
    }

    /**
     * Check if the user has completed the onboarding process.
     *
     * @param  User  $user
     *
     * @return bool
     */
    private function userIsOnboarded(User $user): bool
    {
        $userId   = $user->id;
        $cacheKey = "user:{$userId}:onboarding_status";

        // Cache the onboarding status per user
        return Cache::remember($cacheKey, 60, function () use ($user) {
            return $user->metricExists(MetricKey::ONBOARDING_COMPLETED);
        });
    }
}
