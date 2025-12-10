<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// FIX 1: Import Model Peminjaman agar tidak "Class not found"
use App\Models\Peminjaman; 

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman.
     */
    public function index()
    {
        // Ambil data dengan relasi 'user' dan 'item' (bukan task)
        $peminjaman = Peminjaman::with(['user', 'item'])->latest()->paginate(10);
        return view('admin.pinjam', compact('peminjaman')); // Arahkan ke view admin.pinjam
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