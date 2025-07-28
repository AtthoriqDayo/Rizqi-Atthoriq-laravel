<?php

use App\Http\Controllers\Auth\GoogleAuthController; // Make sure this line is at the top
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('entrance');
});

Route::get('google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
