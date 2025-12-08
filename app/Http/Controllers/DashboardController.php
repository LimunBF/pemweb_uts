<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // Pastikan pakai model Item

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Barang (Menghitung jumlah baris data barang)
        $total_barang = Item::count();

        // 2. Barang Dipinjam
        $barang_dipinjam = Item::where('status_ketersediaan', 'Dipinjam')->count();

        // 3. Barang Tersedia
        $barang_tersedia = Item::where('status_ketersediaan', 'Tersedia')->count();

        $data = [
            'total_barang'    => $total_barang,
            'barang_dipinjam' => $barang_dipinjam,
            'barang_tersedia' => $barang_tersedia,
            'user_name'       => 'Admin'
        ];

        return view('admin.dashboard_admin', $data);
    }
}