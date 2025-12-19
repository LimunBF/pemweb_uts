<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController; // Pastikan ini ada
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserDashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// --- AUTHENTICATION ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Pakai fungsi di AuthController
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// --- ROUTE ADMIN (Perlu Login) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

    // Manajemen Inventaris 
    Route::resource('items', ItemController::class);

    // Route khusus untuk ItemController yang Anda buat manual
    Route::get('/barang', [ItemController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [ItemController::class, 'create'])->name('barang.create');
    Route::post('/barang', [ItemController::class, 'store'])->name('barang.store');
    
    // --- TAMBAHAN: Edit & Update Barang ---
    // Route untuk menampilkan form edit (sesuai ItemController::edit)
    Route::get('/barang/{id}/edit', [ItemController::class, 'edit'])->name('barang.edit');
    // Route untuk proses update (sesuai ItemController::update, method PUT)
    Route::put('/barang/{id}', [ItemController::class, 'update'])->name('barang.update');
    // Route untuk menghapus barang (opsional, jika tombol delete ada)
    Route::delete('/barang/{id}', [ItemController::class, 'destroy'])->name('barang.destroy');
   
    // Anggota (Members)
    Route::resource('members', MemberController::class);

    // --- PEMINJAMAN ADMIN ---
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    
    // [BARU] Route untuk Form Tambah Peminjaman oleh Admin
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    
    // [BARU] Route untuk Simpan Peminjaman oleh Admin
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    
    // Route untuk update status peminjaman (Approve/Reject/Kembali)
    Route::patch('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    
});

// --- ROUTE MAHASISWA / USER ---
Route::prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/inventory', [UserDashboardController::class, 'inventory'])->name('inventory');
    Route::get('/my-loans', [UserDashboardController::class, 'myLoans'])->name('loans');
    Route::get('/loan-form', [UserDashboardController::class, 'loanForm'])->name('loan.form');
    Route::post('/loan-form', [UserDashboardController::class, 'storeLoan'])->name('loan.store');
});


// --- SHORTCUT DEBUG (Hapus saat Production) ---
// Ini untuk login cepat tanpa mengetik password
// --- SHORTCUT DEBUG (Hapus saat Production) ---
Route::get('/debug/login-admin', function () {
    $user = User::where('email', 'admin@lab.com')->first();
    if($user) { 
        Auth::login($user); 
        return redirect()->route('dashboard_admin'); 
    }
    return "User admin tidak ditemukan. Jalankan: php artisan migrate:fresh --seed";
});

    if($user) { Auth::login($user); return redirect()->route('dashboard_admin'); }
    return "User admin tidak ditemukan. Jalankan: php artisan migrate:fresh --seed";
});

Route::get('/debug/login-mhs', function () {
    $user = User::where('email', 'mahasiswa@lab.com')->first();
    if($user) { Auth::login($user); return redirect()->route('student.dashboard'); }
    return "User mahasiswa tidak ditemukan.";
});

Route::get('/debug/logout', function () {
    Auth::logout();
    return redirect('/login');
});

// -- RUTE DAFTAR ANGGOTA
Route::get('/members', [MemberController::class, 'index'])->name('members.index');