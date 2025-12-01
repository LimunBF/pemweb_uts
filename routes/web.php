<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController; 
use App\Http\Controllers\DashboardController; // Pastikan baris ini ada

// Route Halaman Utama (Task List)
Route::get('/', [TaskController::class, 'index']);

// Route CRUD Tasks
Route::resource('tasks', TaskController::class);

// Route Dashboard Admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');