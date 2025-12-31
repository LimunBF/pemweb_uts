<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;       
use App\Models\Peminjaman; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Pastikan import Carbon

class DashboardController extends Controller
{
    public function index()
    {      
        $total_barang = Item::sum('jumlah_total');
        $barang_dipinjam = Peminjaman::whereIn('status', ['dipinjam', 'terlambat', 'disetujui'])
                            ->sum('amount');

        $barang_tersedia = $total_barang - $barang_dipinjam;
        if ($barang_tersedia < 0) $barang_tersedia = 0;
        $monthly_data = Peminjaman::whereYear('created_at', date('Y'))
            ->get() // Ambil data dulu
            ->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('n');
            })
            ->map(function ($row) {
                return $row->count();
            })
            ->toArray();

        $chart_peminjaman = [];
        for ($i = 1; $i <= 12; $i++) {
            $chart_peminjaman[] = $monthly_data[$i] ?? 0;
        }

        $chart_status = [
            'tersedia' => $barang_tersedia,
            'dipinjam' => $barang_dipinjam
        ];

        $data = [
            'total_barang'     => $total_barang,
            'barang_dipinjam'  => $barang_dipinjam,
            'barang_tersedia'  => $barang_tersedia,
            'chart_peminjaman' => $chart_peminjaman, 
            'chart_status'     => $chart_status,   
            'user_name'        => 'Admin' 
        ];

        return view('admin.dashboard_admin', $data);
    }
}