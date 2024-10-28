<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/**
 * Table of contents:
 * - 1. Marketing routes
 * - 2. Temporary routes
 * - 3. Onboarding routes
 * - 4. Settings routes
 * - 5. Auth routes
 * - 6. High-priority routes
 * - 7. Development routes (local only)
 */

// 1. Marketing routes

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
})->name('home');

// 2. Temporary routes

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

// 3. Onboarding routes

Route::middleware('auth')
    ->prefix('/onboarding')
    ->name('onboarding.')
    ->group(base_path('/routes/web/onboarding.php'));

// 4. Settings routes

Route::middleware('auth')
    ->prefix('/settings')
    ->name('settings.')
    ->group(base_path('/routes/web/settings.php'));

// 5. Auth routes

Route::group([], base_path('/routes/web/auth.php'));

// 6. High-priority routes

Route::get('/{blog:slug}', function () {
    return Inertia::render('Blog');
})->name('blogs.show');

/* 7. Development routes (local only)
 * - - - - - - - - - - - - - */

if (app()->isLocal() && app()->hasDebugModeEnabled()) {
    Route::prefix('/dev')
        ->name('dev.')
        ->group(base_path('/routes/web/dev.php'));
}
