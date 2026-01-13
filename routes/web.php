<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


Route::middleware('auth')->group(function () {
     Route::get('/dashboard', function () {
            return view('panel.dashboard');
        })->name('dashboard');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

