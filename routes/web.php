<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController; // <-- PENTING: Wajib di-import agar tidak error


// --- 1. JALUR LOGIN & LOGOUT (Bisa diakses siapa saja)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- 2. JALUR RAHASIA (Hanya bisa diakses jika sudah Login) ---
// Middleware 'auth' akan menendang user yang belum login kembali ke halaman login
Route::middleware(['auth'])->group(function () {
    
    // Jika user membuka halaman utama (localhost:8000), langsung arahkan ke daftar tugas
    Route::get('/', function () {
        return redirect()->route('tasks.index');
    });

    // Jalur CRUD Lengkap untuk Inventaris (index, create, store, edit, update, destroy)
    Route::resource('tasks', TaskController::class);
});
=======
use App\Http\Controllers\TaskController; 
use App\Http\Controllers\DashboardController; // Pastikan baris ini ada

// Route Halaman Utama (Task List)
Route::get('/', [TaskController::class, 'index']);

// Route CRUD Tasks
Route::resource('tasks', TaskController::class);

// Route Dashboard Admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');
>>>>>>> fdea6ccedfef8391d6de4af05bbe86079ef0d6be
