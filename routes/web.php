<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;



// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register (Pendaftaran Akun Baru)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::middleware(['auth'])->group(function () {
    
    // Dashboard (Halaman Utama saat login sukses)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

    // Inventaris (Tasks)
    Route::resource('tasks', TaskController::class);

    // Anggota (Members)
    Route::resource('members', MemberController::class);

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
});

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
