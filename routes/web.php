<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController; 
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes (Peta Jalan Aplikasi)
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. JALUR PUBLIK (Landing, Login, Register, Logout)
// ====================================================

// --- [REVISI] HALAMAN UTAMA (ROOT) ---
Route::get('/', function () {
    // 1. Cek apakah user SUDAH login?
    if (Auth::check()) {
<<<<<<< HEAD
        // Jika Mahasiswa/Dosen -> Redirect ke Dashboard Student
=======
        // Cek apakah role user ada di dalam daftar ['mahasiswa', 'dosen']
>>>>>>> feature/inventaris
        if (in_array(Auth::user()->role, ['mahasiswa', 'dosen'])) {
            return redirect()->route('student.dashboard');
        }
        // Jika Admin -> Redirect ke Dashboard Admin
        return redirect()->route('dashboard_admin');
    }

    // 2. Jika BELUM login -> Tampilkan Landing Page (Welcome)
    // return redirect()->route('login'); // DULU: <-- Kode Lama (Dikomentari)
    return view('welcome'); // <-- Kode Baru (Tampilkan Landing Page)
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


// ====================================================
// 2. JALUR RAHASIA (Wajib Login)
// ====================================================
Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARD ADMIN ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

    // --- MANAJEMEN BARANG (INVENTARIS) ---
    Route::resource('items', ItemController::class);
    Route::resource('tasks', ItemController::class); 
    Route::get('/inventaris', [ItemController::class, 'index'])->name('inventaris.index');
    
    // Route spesifik barang
    // PENTING: Route cetak harus didefinisikan sebelum route parameter {id}
    Route::get('/barang/cetak', [ItemController::class, 'cetak'])->name('barang.cetak');
    
    Route::get('/barang', [ItemController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [ItemController::class, 'create'])->name('barang.create');
    Route::post('/barang', [ItemController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [ItemController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [ItemController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [ItemController::class, 'destroy'])->name('barang.destroy');

    // --- MANAJEMEN ANGGOTA ---
    Route::resource('members', MemberController::class);

    // --- PEMINJAMAN (ADMIN) ---
    Route::get('/peminjaman/cetak', [App\Http\Controllers\PeminjamanController::class, 'cetak'])->name('peminjaman.cetak');
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::patch('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::patch('/peminjaman/{id}/confirm', [PeminjamanController::class, 'confirm'])->name('peminjaman.confirm');

    // --- AREA MAHASISWA & DOSEN (STUDENT DASHBOARD) ---
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
        Route::get('/inventory', [UserDashboardController::class, 'inventory'])->name('inventory');
        Route::get('/my-loans', [UserDashboardController::class, 'myLoans'])->name('loans');
        
        // Form Peminjaman
        Route::get('/loan-form', [UserDashboardController::class, 'loanForm'])->name('loan.form');
        Route::post('/loan-form', [UserDashboardController::class, 'storeLoan'])->name('loan.store');
        
        // Print Surat
        Route::get('/my-loans/{id}/print', [UserDashboardController::class, 'printSurat'])->name('loan.print');

        // EDIT PROFIL ---
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

});


// ====================================================
// 3. JALUR DEBUG (Hapus saat Production)
// ====================================================

Route::get('/debug/login-admin', function () {
    $user = User::where('email', 'admin@lab.com')->first();
    if($user) { 
        Auth::login($user); 
        return redirect()->route('dashboard_admin'); 
    }
    return "User admin tidak ditemukan. Jalankan: php artisan migrate:fresh --seed";
});

Route::get('/debug/login-mhs', function () {
    $user = User::where('role', 'mahasiswa')->first();
    if($user) { 
        Auth::login($user); 
        return redirect()->route('student.dashboard'); 
    }
    return "User mahasiswa tidak ditemukan.";
});

Route::get('/debug/logout', function () {
    Auth::logout();
    return redirect('/login');
});