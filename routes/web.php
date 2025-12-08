<?php

use Illuminate\Support\Facades\Route;
// Import semua Controller yang dipakai
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;


// Halaman Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Proses Login (saat tombol ditekan)
Route::post('/login', [AuthController::class, 'login']);
// Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    
    // 1. DASHBOARD
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Atau bisa juga diakses via /dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

    // 2. INVENTARIS (TASKS)
    Route::resource('tasks', TaskController::class);

    // 3. ANGGOTA (MEMBERS)
    Route::resource('members', MemberController::class);

    // 4. PEMINJAMAN
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
});