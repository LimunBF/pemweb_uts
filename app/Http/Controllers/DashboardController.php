<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;       // Model Barang
use App\Models\Peminjaman; // [WAJIB] Model Peminjaman

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Aset: Jumlah total unit fisik dari semua barang
        $total_barang = Item::sum('jumlah_total');

        // 2. Sedang Dipinjam: Menghitung data dari tabel Peminjaman
        // UPDATE: Saya masukkan SEMUA kemungkinan status yang Anda sebutkan ('disetujui', 'pending')
        // ditambah status bawaan seeder ('dipinjam', 'terlambat').
        $barang_dipinjam = Peminjaman::whereIn('status', [
            'dipinjam', 
            'terlambat', 
            'pending', 
            'disetujui'  // <--- Status ini penting agar data Anda terbaca
        ])->count();

        // 3. Barang Tersedia: Total Aset dikurangi yang sedang dipinjam/aktif
        $barang_tersedia = $total_barang - $barang_dipinjam;

        // Mencegah angka minus
        if ($barang_tersedia < 0) {
            $barang_tersedia = 0;
        }

        $data = [
            'total_barang'    => $total_barang,
            'barang_dipinjam' => $barang_dipinjam,
            'barang_tersedia' => $barang_tersedia,
            'user_name'       => 'Admin' 
        ];

        return view('admin.dashboard_admin', $data);
    }
}