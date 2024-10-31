<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Blog;

Route::get('/', [Blog\HomeController::class, 'index'])
    ->name('index');

Route::get('/archive/', [Blog\ArchiveController::class, 'index'])
    ->name('archive.index');

Route::get('/p/{post:slug}', [Blog\PostController::class, 'show'])
    ->name('posts.show');

Route::get('/about/', [Blog\AboutController::class, 'index'])
    ->name('about.index');

Route::get('/subscription/verify/{subscription}/{token}', [Blog\SubscriptionController::class, 'verify'])
    ->name('subscription.verify');

Route::post('/subscription/', [Blog\SubscriptionController::class, 'store'])
    ->name('subscription.store');
