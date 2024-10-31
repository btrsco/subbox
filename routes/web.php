<?php

use App\Http\Controllers\Blog\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/**
 * Table of contents:
 * 1. Marketing routes
 * 2. Temporary routes
 * 3. Authenticated routes
 * 4. Guest routes
 * 5. High-priority routes
 * 6. Development routes (local only)
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

// ...

// 3. Authenticated routes

Route::middleware('auth')
    ->prefix('/onboarding')
    ->name('onboarding.')
    ->group(base_path('/routes/web/onboarding.php'));

Route::middleware('auth')
    ->prefix('/dashboard')
    ->name('dashboard.')
    ->group(base_path('/routes/web/dashboard.php'));

// 4. Guest routes

Route::group([], base_path('/routes/web/auth.php'));

// 5. High-priority routes

Route::get('/@{blog:slug}', [HomeController::class, 'index'])->name('blog.index');
Route::get('/@{blog:slug}/posts/{post:slug}', [HomeController::class, 'index'])->name('blog.posts.show');

/* 6. Development routes (local only)
 * - - - - - - - - - - - - - */

if (app()->isLocal() && app()->hasDebugModeEnabled()) {
    Route::prefix('/dev')
        ->name('dev.')
        ->group(base_path('/routes/web/dev.php'));
}
