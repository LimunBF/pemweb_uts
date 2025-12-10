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
        // 1. Ambil data dari database dengan relasi user dan task
        // Pastikan model Peminjaman memiliki method user() dan task()
        $peminjaman = Peminjaman::with(['user', 'task'])->latest()->paginate(10);

        // 2. Tampilkan ke layar (View)
        // KEMBALIKAN KE 'layouts.pinjam'
        // Ini berarti Laravel akan mencari file di: resources/views/layouts/pinjam.blade.php
        return view('layouts.pinjam', compact('peminjaman'));
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