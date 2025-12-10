<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // <--- Import Model Barang

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data dari database
        // Pastikan tabel 'barangs' sudah ada isinya
        $total_barang    = Barang::count();
        $barang_dipinjam = Barang::where('status', 'dipinjam')->count();
        $barang_tersedia = Barang::where('status', 'tersedia')->count();

        // 2. Bungkus data ke dalam array
        $data = [
            'total_barang'    => $total_barang,
            'barang_dipinjam' => $barang_dipinjam,
            'barang_tersedia' => $barang_tersedia,
            'user_name'       => 'Admin' // Nanti bisa diganti Auth::user()->name
        ];

        return view('admin.dashboard_admin', $data);
    }
}