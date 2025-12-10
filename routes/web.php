<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController; 
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\PeminjamanController;

// ... (Kode route yang sudah ada sebelumnya biarkan saja) ...

Route::get('/inventaris', [TaskController::class, 'index'])->name('inventaris');
Route::resource('tasks', TaskController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_admin');
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
Route::post('/logout', function () {
    return redirect('/dashboard'); 
    })->name('logout'); 