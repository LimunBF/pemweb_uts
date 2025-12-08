<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ItemController; 
// --- Route yang Benar ---

// 1. Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');

// 2. Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');

// 3. Manajemen Barang (Item)
Route::resource('items', ItemController::class);

// 4. Redirect halaman /inventaris ke index Item
Route::get('/inventaris', [ItemController::class, 'index'])->name('inventaris.index');