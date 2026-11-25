<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkLogController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/work-logs');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
    Route::resource('work-logs', WorkLogController::class)->except('show');
});
