<?php

use App\Http\Controllers\Settings\AccountController;
use App\Http\Controllers\Settings\PasskeyController;
use App\Http\Controllers\Settings\SecurityController;
use App\Http\Controllers\Settings\SessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'edit'])->name('edit');
    Route::patch('/', [AccountController::class, 'update'])->name('update');
    Route::delete('/', [AccountController::class, 'destroy'])->name('destroy');
});

Route::prefix('/security')->name('security.')->group(function () {
    Route::get('/', [SecurityController::class, 'edit'])->name('edit');
    Route::patch('/', [SecurityController::class, 'update'])->name('update');
})->middleware('password.confirm');

Route::prefix('/sessions')->name('sessions.')->group(function () {
    Route::get('/', [SessionController::class, 'edit'])->name('edit');
    Route::delete('/{session}', [SessionController::class, 'destroy'])->name('destroy');
    Route::delete('/', [SessionController::class, 'purge'])->name('purge');
});
