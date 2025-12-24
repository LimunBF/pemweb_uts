<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // --- FITUR ADMIN: LIHAT DAFTAR ---
    public function index()
    {
        // Ambil data peminjaman urut dari yang terbaru
        $peminjaman = Peminjaman::with(['user', 'item'])->latest()->paginate(10);
        return view('admin.pinjam', compact('peminjaman'));
    }

    // --- FITUR MAHASISWA: AJUKAN PINJAM ---
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // 2. Cek Stok Barang
        $item = Item::findOrFail($request->item_id);
        if ($item->jumlah_total < 1 || $item->status_ketersediaan != 'Tersedia') {
            return back()->withErrors(['item_id' => 'Stok barang habis atau sedang tidak tersedia.'])->withInput();
        }

        // 3. Simpan ke Database
        Peminjaman::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'menunggu_persetujuan',
        ]);

        // 4. Kembali ke halaman riwayat
        return redirect()->route('student.loans')->with('success', 'Pengajuan berhasil! Menunggu persetujuan Admin.');
    }

    // --- FITUR ADMIN: KONFIRMASI (TERIMA/TOLAK) ---
    public function confirm(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Validasi status yang dikirim tombol
        $request->validate(['status' => 'required|in:disetujui,ditolak,kembali']);

        // Update status & catat siapa adminnya
        $peminjaman->update([
            'status' => $request->status,
            'approver_id' => Auth::id()
        ]);

        return back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}