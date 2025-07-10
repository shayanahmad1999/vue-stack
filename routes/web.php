<?php

use App\Http\Controllers\PostDestroyController;
use App\Http\Controllers\PostEditController;
use App\Http\Controllers\PostIndexController;
use App\Http\Controllers\PostStoreController;
use App\Http\Controllers\PostUpdateController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'multiRole:admin,creator'])
    ->prefix('posts')
    ->name('posts.')
    ->group(function () {
        Route::get('/', PostIndexController::class)->name('index');
        Route::inertia('/create', 'posts/Create')->name('create');
        Route::post('/store', PostStoreController::class)->name('store');
        Route::get('/{post}/edit', PostEditController::class)->name('edit');
        Route::put('/{post}/update', PostUpdateController::class)->name('update');
        Route::get('/{post}/delete', PostDestroyController::class)->name('delete');
    });

Route::middleware(['auth', 'verified', 'multiRole:admin'])
    ->prefix('users')
    ->name('users.')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}/update', 'update')->name('update');
        Route::get('/{user}/delete', 'destroy')->name('delete');
    });

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
