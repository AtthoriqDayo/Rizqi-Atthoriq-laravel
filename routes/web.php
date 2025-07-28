<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
Route::get('/', function () {
    return view('welcome');
});

// Google Auth Routes
Route::get('google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');


Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function() {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    // Add these routes for user management
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [GoogleAuthController::class, 'logout'])->name('logout');

    // User Dashboard
    Route::get('/dashboard', UserDashboardController::class)->name('dashboard');

    // Admin Dashboard (Protected by 'is_admin' middleware)
    Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function() {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        // Add other admin routes here for user management
    });
});
