<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;       // Model Barang
use App\Models\Peminjaman; // [WAJIB] Model Peminjaman
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {      
        $total_barang = Item::sum('jumlah_total');
        $barang_dipinjam = Peminjaman::whereIn('status', ['dipinjam', 'terlambat', 'disetujui'])->count();
        $barang_tersedia = $total_barang - $barang_dipinjam;
        if ($barang_tersedia < 0) $barang_tersedia = 0;

        $monthly_data = Peminjaman::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month')
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