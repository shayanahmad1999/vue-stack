<?php

use App\Http\Controllers\PostDestroyController;
use App\Http\Controllers\PostEditController;
use App\Http\Controllers\PostIndexController;
use App\Http\Controllers\PostStoreController;
use App\Http\Controllers\PostUpdateController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->prefix('posts')
    ->name('posts.')
    ->group(function () {
        Route::get('/', PostIndexController::class)->name('index');
        Route::inertia('/create', 'posts/Create')->name('create');
        Route::post('/store', PostStoreController::class)->name('store');
        Route::get('/{post}/edit', PostEditController::class)->name('edit');
        Route::put('/{post}/update', PostUpdateController::class)->name('update');
        Route::delete('/{post}/delete', PostDestroyController::class)->name('delete');
    });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
