<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', [Dashboard\HomeController::class, 'index'])
    ->name('index');
Route::post('/hide-welcome', [Dashboard\HomeController::class, 'hideWelcome'])
    ->name('hide-welcome');

Route::prefix('/posts')->name('posts.')->group(function () {
    Route::get('/', [Dashboard\PostController::class, 'index'])
        ->name('index');
    Route::get('/new', [Dashboard\PostController::class, 'create'])
        ->name('create');
    Route::get('/{post}/edit', [Dashboard\PostController::class, 'edit'])
        ->name('edit');
    Route::patch('/{post}/unpublish', [Dashboard\PostController::class, 'unpublish'])
        ->name('unpublish');
    Route::patch('/{post}', [Dashboard\PostController::class, 'update'])
        ->name('update');
    Route::delete('/{post}', [Dashboard\PostController::class, 'destroy'])
        ->name('destroy');
});

Route::prefix('/subscribers')->name('subscribers.')->group(function () {
    Route::get('/', [Dashboard\SubscriberController::class, 'index'])
        ->name('index');
    Route::delete('/{subscription}', [Dashboard\SubscriberController::class, 'destroy'])
        ->name('destroy');
});

Route::prefix('/settings')->name('settings.')->group(function () {
    Route::prefix('/account')->name('account.')->group(function () {
        Route::get('/', [Dashboard\Settings\AccountController::class, 'edit'])
            ->name('edit');
        Route::patch('/', [Dashboard\Settings\AccountController::class, 'update'])
            ->name('update');
        Route::delete('/', [Dashboard\Settings\AccountController::class, 'destroy'])
            ->name('destroy');
    });

    Route::prefix('/security')->name('security.')->group(function () {
        Route::get('/', [Dashboard\Settings\SecurityController::class, 'edit'])
            ->name('edit');
        Route::patch('/', [Dashboard\Settings\SecurityController::class, 'update'])
            ->name('update');
    })->middleware('password.confirm');

    Route::prefix('/sessions')->name('sessions.')->group(function () {
        Route::get('/', [Dashboard\Settings\SessionController::class, 'edit'])
            ->name('edit');
        Route::delete('/{session}', [Dashboard\Settings\SessionController::class, 'destroy'])
            ->name('destroy');
        Route::delete('/', [Dashboard\Settings\SessionController::class, 'purge'])
            ->name('purge');
    });
});
