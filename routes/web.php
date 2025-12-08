<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;      
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\TaskController;      
use App\Http\Controllers\MemberController;    
use App\Http\Controllers\PeminjamanController;


// --- 1. JALUR LOGIN & LOGOUT (Publik) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- 2. JALUR UTAMA (Wajib Login) ---
Route::middleware(['auth'])->group(function () {
    
    // Halaman Utama -> Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Opsi lain jika ingin akses via /dashboard juga
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

    // CRUD Inventaris (Tasks)
    Route::resource('tasks', TaskController::class);

    // CRUD Anggota (Members)
    Route::resource('members', MemberController::class);

    // CRUD Peminjaman
    Route::resource('peminjaman', PeminjamanController::class);
});