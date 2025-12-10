<?php

use Illuminate\Support\Facades\Route;
// Import semua Controller yang dipakai
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ItemController; 
use App\Http\Controllers\UserDashboardController;
use Illuminate\Http\Request;

// --- Route yang Benar ---

// 1. Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

// 2. Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');

// 3. Manajemen Barang (Item)
Route::resource('items', ItemController::class);

// 4. Redirect halaman /inventaris ke index Item
Route::get('/inventaris', [ItemController::class, 'index'])->name('inventaris.index');

// Route Khusus Mahasiswa / User Biasa
Route::get('/student-dashboard', [UserDashboardController::class, 'index'])->name('student.dashboard');


// Route Khusus Mahasiswa / User Biasa
Route::prefix('student')->name('student.')->group(function () {
    // 1. Dashboard Utama (Katalog)
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // 2. Halaman Inventaris (Tabel Stok)
    Route::get('/inventory', [UserDashboardController::class, 'inventory'])->name('inventory');
    
    // 3. Halaman Detail Peminjaman & Deadline
    Route::get('/my-loans', [UserDashboardController::class, 'myLoans'])->name('loans');
    
    // Route Form Peminjaman (Hidden Menu)
    Route::get('/loan-form', [UserDashboardController::class, 'loanForm'])->name('loan.form');
    Route::post('/loan-form', [UserDashboardController::class, 'storeLoan'])->name('loan.store');
});

use App\Models\User;
use Illuminate\Support\Facades\Auth;
// --- SHORTCUT LOGIN (HAPUS NANTI SAAT PRODUCTION) ---
// 1. Jalan Pintas Login sebagai ADMIN
Route::get('/debug/login-admin', function () {
    $user = User::where('email', 'admin@lab.com')->first();
    Auth::login($user); // Login otomatis
    return redirect()->route('dashboard_admin'); // Lempar ke dashboard admin
});

// 2. Jalan Pintas Login sebagai MAHASISWA
Route::get('/debug/login-mhs', function () {
    $user = User::where('email', 'mahasiswa@lab.com')->first();
    Auth::login($user); // Login otomatis
    return redirect()->route('student.dashboard'); // Lempar ke dashboard mahasiswa
});

// 3. Jalan Pintas LOGOUT
Route::get('/debug/logout', function () {
    Auth::logout();
    return "Berhasil Logout! <a href='/debug/login-admin'>Login Admin</a> | <a href='/debug/login-mhs'>Login Mhs</a>";
});

// --- RUTE LOGOUT (Wajib ada karena dipanggil di sidebar) ---
Route::post('/logout', function (Request $request) {
    // 1. Logout user
    Auth::logout();
    
    // 2. Invalidate session (standar keamanan Laravel)
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    // 3. Redirect (Misal: kembali ke halaman inventaris atau halaman debug)
    return redirect('/inventaris'); 
})->name('logout');


// -- RUTE DAFTAR ANGGOTA
Route::get('/members', [MemberController::class, 'index'])->name('members.index');