<?php

use Illuminate\Support\Facades\Route;
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