<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\Item;
use App\Models\User;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman.
     */
    public function index()
    {
        // Mengambil data peminjaman dengan relasi user dan item
        $loans = Peminjaman::with(['user', 'item'])->latest()->get();

        // PERBAIKAN 1: Arahkan ke folder 'admin', nama file 'pinjam'
        // Lokasi asli: resources/views/admin/pinjam.blade.php
        // JANGAN pakai .blade.php di dalam fungsi view()
        return view('admin.pinjam', compact('loans'));
    }

    /**
     * MENAMPILKAN FORM TAMBAH PEMINJAM (Admin)
     */
    public function create()
    {
        // 1. Ambil data mahasiswa (selain admin)
        $users = User::where('role', '!=', 'admin')->get(); 

        // 2. Ambil data barang
        $items = Item::all();

        // PERBAIKAN 2: Arahkan ke folder 'admin', nama file 'create_peminjaman'
        // Lokasi asli: resources/views/admin/create_peminjaman.blade.php
        return view('admin.create_peminjam', compact('users', 'items'));
    }

    /**
     * MENYIMPAN DATA PEMINJAMAN (Admin)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'item_id' => 'required|exists:items,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'alasan' => 'nullable|string',
        ]);

        // 2. Simpan ke Database
        // Pastikan nama kolom sebelah KIRI sesuai dengan Database kamu.
        // Jika database pakai bahasa inggris (loan_date), gunakan itu. 
        // Jika pakai bahasa indonesia (tanggal_pinjam), ganti yang kiri jadi tanggal_pinjam.
        Peminjaman::create([
            'user_id' => $request->user_id,
            'item_id' => $request->item_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,     
            'tanggal_kembali' => $request->tanggal_kembali,   
            'alasan' => $request->alasan,                
            'status' => 'Approved', // Admin input langsung approved
        ]);

        // 3. Redirect kembali ke halaman index (admin.pinjam)
        return redirect()->route('peminjaman')->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    /**
     * UPDATE STATUS (Setujui / Tolak / Kembali)
     */
    public function update(Request $request, $id)
    {
        $loan = Peminjaman::findOrFail($id);
        
        if ($request->has('status')) {
            $loan->status = $request->status;
            
            // Opsional: Jika status 'returned', set tanggal pengembalian aktual
            // if ($request->status == 'returned') {
            //     $loan->actual_return_date = now();
            // }

            $loan->save();
        }

        return redirect()->back()->with('success', 'Status peminjaman diperbarui.');
    }
}