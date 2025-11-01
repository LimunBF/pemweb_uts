<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController; // <-- Mereka akan impor controller

// Ini rute baru untuk halaman utama
Route::get('/', [TaskController::class, 'index']);

// Ini rute untuk semua fitur CRUD (tambah, edit, hapus, dll)
Route::resource('tasks', TaskController::class);