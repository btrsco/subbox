<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/**
 * Table of contents:
 * 1. Marketing routes
 * 2. Authenticated routes
 * 3. Guest routes
 * 4. Development routes (local only)
 */

// 1. Marketing routes

Route::get('/', function() {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }

    return Inertia::render('Index');
})->name('home');

// 2. Authenticated routes

Route::middleware('auth')
    ->prefix('/onboarding')
    ->name('onboarding.')
    ->group(base_path('/routes/web/onboarding.php'));

Route::middleware('auth')
    ->prefix('/dashboard')
    ->name('dashboard.')
    ->group(base_path('/routes/web/dashboard.php'));

// 3. Guest routes

Route::group([], base_path('/routes/web/auth.php'));

Route::prefix('/@{blog:slug}')
    ->name('blog.')
    ->group(base_path('/routes/web/blog.php'));

/* 4. Development routes (local only)
 * - - - - - - - - - - - - - */

if (app()->isLocal() && app()->hasDebugModeEnabled()) {
    Route::prefix('/dev')
        ->name('dev.')
        ->group(base_path('/routes/web/dev.php'));
}
