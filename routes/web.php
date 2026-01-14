<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LocaleController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');



Route::group([
    'middleware' => ['auth', 'lang'],
], function () {
     Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

    Route::resource('leads', LeadController::class);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::post('leads/{lead}/tasks', [TaskController::class, 'store'])->name('leads.tasks.store');
});
