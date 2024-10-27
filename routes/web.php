<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')
    ->prefix('/settings')
    ->name('settings.')
    ->group(base_path('/routes/web/settings.php'));

Route::group([], base_path('/routes/web/auth.php'));

/**
 * Development routes
 *
 * Only available in local environment with debug mode enabled.
 */

if (app()->isLocal() && app()->hasDebugModeEnabled()) {
    Route::prefix('/dev')
        ->name('dev.')
        ->group(base_path('/routes/web/dev.php'));
}
