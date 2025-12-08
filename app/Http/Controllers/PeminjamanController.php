<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman.
     */
    public function index()
    {
        // Nanti logika pengambilan data database ada di sini
        // Contoh: $data_pinjam = Peminjaman::with('user', 'item')->get();
        
        // Untuk sekarang kita tampilkan view-nya dulu
        return view('admin.pinjam');
    }

    /**
     * Menampilkan form untuk menambah peminjam baru.
     */
    public function create()
    {
        // Return view form tambah peminjaman
    }

    /**
     * Menyimpan data peminjaman baru ke database.
     */
    public function store(Request $request)
    {
        // Logika simpan data
    }
}