<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ItemController; 
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\TaskController; 


// PERBAIKAN DI SINI: Halaman Utama Pintar
Route::get('/', function () {
    // Cek apakah user sudah login?
    if (Auth::check()) {
        // Jika sudah login, arahkan sesuai role
        if (Auth::user()->role == 'mahasiswa') {
            return redirect()->route('student.dashboard');
        }
        // Jika Admin atau Dosen
        return redirect()->route('dashboard_admin');
    }
    // Jika belum login, barulah ke halaman login
    return redirect()->route('login');
});

// Route Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD ADMIN ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');
    
    // --- MANAJEMEN BARANG (Items/Tasks) ---
    Route::resource('items', ItemController::class);
    Route::resource('tasks', ItemController::class); 
    Route::get('/inventaris', [ItemController::class, 'index'])->name('inventaris.index');

    // --- MANAJEMEN ANGGOTA (Members) ---
    Route::resource('members', MemberController::class);

    // --- PEMINJAMAN ---
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');

    // --- AREA MAHASISWA (Student) ---
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/inventory', [UserDashboardController::class, 'inventory'])->name('inventory');
        Route::get('/my-loans', [UserDashboardController::class, 'myLoans'])->name('loans');
        Route::get('/loan-form', [UserDashboardController::class, 'loanForm'])->name('loan.form');
        Route::post('/loan-form', [UserDashboardController::class, 'storeLoan'])->name('loan.store');
    });

});



use App\Models\User;

Route::get('/debug/login-admin', function () {
    $user = User::where('email', 'admin@lab.com')->first();
    if($user) {
        Auth::login($user);
        return redirect()->route('dashboard_admin');
    }
    return "User admin tidak ditemukan. Jalankan seeder dulu.";
});

Route::get('/debug/login-mhs', function () {
    $user = User::where('role', 'mahasiswa')->first();
    if($user) {
        Auth::login($user);
        return redirect()->route('student.dashboard');
    }
    return "User mahasiswa tidak ditemukan.";
});