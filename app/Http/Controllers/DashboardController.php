<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item; // Pastikan pakai 'Item'

class DashboardController extends Controller
{
    public function index()
    {
        $total_barang = Item::count();
        $barang_dipinjam = Item::where('status_ketersediaan', 'Dipinjam')->count();
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