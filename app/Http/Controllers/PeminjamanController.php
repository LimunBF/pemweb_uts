<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // =========================================================================
    // 1. FITUR ADMIN: LIST KONFIRMASI & RIWAYAT (DENGAN FILTER)
    // =========================================================================
    public function index(Request $request)
    {
        // A. Permintaan Baru (Status: Pending) -> Untuk Notifikasi Kotak Kuning
        // Ini selalu ditampilkan di paling atas
        $pendingLoans = Peminjaman::with(['user', 'item'])
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'asc')
                        ->get();

        // B. Riwayat Peminjaman (Data Utama Tabel Bawah)
        // Kita gunakan nama variable '$peminjaman' agar pagination di view tidak error
        $query = Peminjaman::with(['user', 'item'])
                           ->where('status', '!=', 'pending'); // Jangan tampilkan yang pending (karena sudah ada di atas)

        // --- LOGIKA FILTER (DARI KODE LAMA) ---
        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter Tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // Ambil data dengan pagination
        $peminjaman = $query->latest()->paginate(10);
        
        // Kembalikan ke view 'admin.pinjam'
        return view('admin.pinjam', compact('peminjaman', 'pendingLoans'));
    }

    // =========================================================================
    // 2. FITUR MAHASISWA: AJUKAN PINJAM
    // =========================================================================
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'amount' => 'required|integer|min:1', 
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Cek Stok menggunakan Accessor 'stok_ready' di Model Item
        $item = Item::findOrFail($request->item_id);
        if ($item->stok_ready < $request->amount) {
            return back()->withErrors(['item_id' => 'Stok barang tidak mencukupi.'])->withInput();
        }

        // Simpan
        Peminjaman::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'amount' => $request->amount,
            'kode_peminjaman' => 'LOAN-' . Auth::id() . '-' . time(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending', // Masuk sebagai pending
            'alasan' => $request->input('alasan', 'Keperluan Praktikum'),
        ]);

        return redirect()->route('student.loans')->with('success', 'Pengajuan berhasil! Menunggu persetujuan Admin.');
    }

    // =========================================================================
    // 3. FITUR ADMIN: UPDATE STATUS (TERIMA / TOLAK / KEMBALI)
    // =========================================================================
    public function update(Request $request, $id)
    {
        $loan = Peminjaman::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,dikembalikan'
        ]);

        $loan->update([
            'status' => $request->status,
            'approver_id' => Auth::id()
        ]);

        // Pesan Feedback
        $msg = match($request->status) {
            'disetujui' => 'Peminjaman DISETUJUI.',
            'ditolak' => 'Peminjaman DITOLAK.',
            'dikembalikan' => 'Barang telah KEMBALI.',
            default => 'Status diperbarui.'
        };

        return back()->with('success', $msg);
    }
}