<?php

use App\Http\Controllers\Onboarding;
use Illuminate\Support\Facades\Route;

Route::get('/blog', [Onboarding\BlogController::class, 'index'])
    ->name('blog');
Route::post('/blog', [Onboarding\BlogController::class, 'store'])
    ->name('blog.store');

Route::get('/subscribers', [Onboarding\SubscribersController::class, 'index'])
    ->name('subscribers');
Route::post('/subscribers', [Onboarding\SubscribersController::class, 'store'])
    ->name('subscribers.store');

Route::get('/complete', [Onboarding\CompleteController::class, 'index'])
    ->name('complete');
Route::post('/complete', [Onboarding\CompleteController::class, 'store'])
    ->name('complete.store');
