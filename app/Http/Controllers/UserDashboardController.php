<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Peminjaman; // Pastikan model ini ada
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    // 1. Dashboard Utama (Katalog Grid)
    public function index()
    {
        $items = Item::latest()->get();
        return view('user.dashboard', compact('items'));
    }

    // 2. Halaman Inventaris (Tabel Stok)
    public function inventory()
    {
        $items = Item::orderBy('nama_alat', 'asc')->get();
        return view('user.inventory', compact('items'));
    }

    // 3. Halaman Peminjaman Saya (Detail & Deadline)
    public function myLoans()
    {
        // Mengambil data peminjaman milik user yang sedang login
        // Pastikan relasi 'item' ada di model Peminjaman
        $loans = Peminjaman::with('item')
                    ->where('user_id', Auth::id())
                    ->orderBy('tanggal_kembali', 'asc') // Urutkan deadline terdekat
                    ->get();

        return view('user.my_loans', compact('loans'));
    }

    // 4. Halaman Form Peminjaman (Hidden Page)
    public function loanForm()
    {
        // Ambil data barang yang statusnya 'Tersedia' saja untuk pilihan di form
        $items = Item::where('status_ketersediaan', 'Tersedia')->orderBy('nama_alat', 'asc')->get();
        
        return view('user.loan_form', compact('items'));
    }

    // 5. Proses Simpan Peminjaman
    public function storeLoan(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan' => 'nullable|string|max:255', // Opsional: Alasan peminjaman
        ]);

        Peminjaman::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending', // Default status menunggu persetujuan admin
        ]);

        return redirect()->route('student.loans')->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu konfirmasi admin.');
    }
}