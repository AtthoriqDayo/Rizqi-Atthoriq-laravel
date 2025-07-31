<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman entrance/animasi
Route::get('/', function () {
    return view('entrance');
});

// Route untuk otentikasi Google
Route::get('google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// Route untuk halaman pemberitahuan "Link Google Account"
Route::get('/google/link', function () {
    return view('auth.link-google');
})->middleware(['auth'])->name('google.link.notice');


// Route utama untuk dashboard user
Route::get('/dashboard', UserDashboardController::class)
    ->middleware(['auth', 'verified', 'google.linked'])->name('dashboard');



// Route untuk halaman profil bawaan Breeze
Route::middleware('auth','verified','google.linked')->group(function () {

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('notes', NoteController::class);
    Route::resource('todos', TodoController::class);
});


// Route untuk semua halaman admin
Route::prefix('admin')
    ->middleware(['auth', 'is_admin', 'google.linked'])
    ->name('admin.')
    ->group(function() {
        Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


// Route untuk login, register, dll. dari Breeze
require __DIR__.'/auth.php';
