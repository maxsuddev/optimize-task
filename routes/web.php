<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('leads', LeadController::class);
    Route::post('task', [TaskController::class, 'store'])->name('task.post');
    Route::post('toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('task', [TaskController::class, 'destroy'])->name('tasks.destroy');
});
