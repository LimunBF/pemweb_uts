<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController; // Pastikan pakai ItemController
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserDashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- AUTHENTICATION ---
Route::get('/', function () { return redirect()->route('login'); }); // Redirect root ke login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// --- GROUP ROUTE ADMIN ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

    // Inventaris (Items)
    Route::resource('items', ItemController::class);

    // Anggota
    Route::resource('members', MemberController::class);

    // Peminjaman (Admin View)
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
});

// --- GROUP ROUTE MAHASISWA ---
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [UserDashboardController::class, 'inventory'])->name('inventory');
    Route::get('/my-loans', [UserDashboardController::class, 'myLoans'])->name('loans');
    
    // Form Peminjaman
    Route::get('/loan-form', [UserDashboardController::class, 'loanForm'])->name('loan.form');
    Route::post('/loan-form', [UserDashboardController::class, 'storeLoan'])->name('loan.store');

    
    // Route Download Surat
    Route::get('/my-loans/{id}/print', [UserDashboardController::class, 'printSurat'])->name('loan.print');
});


// --- SHORTCUT DEBUG (Hapus saat Production) ---
// Ini untuk login cepat tanpa mengetik password
Route::get('/debug/login-admin', function () {
    $user = User::where('email', 'admin@lab.com')->first();
    if($user) { 
        Auth::login($user); 
        return redirect()->route('dashboard_admin'); 
    }
    return "User admin tidak ditemukan. Jalankan: php artisan migrate:fresh --seed";
});

Route::get('/debug/login-mhs', function () {
    $user = User::where('email', 'mahasiswa@lab.com')->first();
    if($user) { 
        Auth::login($user); 
        return redirect()->route('student.dashboard'); 
    }
    return "User mahasiswa tidak ditemukan.";
});
