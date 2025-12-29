<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // 1. DATA PENDING (DIKELOMPOKKAN)
        // Ambil semua yang pending, lalu dikelompokkan berdasarkan 'kode_peminjaman'
        $rawPending = Peminjaman::with(['user', 'item'])
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'asc')
                        ->get();

        // Hasilnya: Daftar Grup
        $pendingLoans = $rawPending->groupBy('kode_peminjaman');

        // 2. DATA RIWAYAT (TETAP SATUAN)
        $query = Peminjaman::with(['user', 'item'])
                           ->where('status', '!=', 'pending');

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Role (Mahasiswa / Dosen)
        if ($request->filled('role')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        // Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // Tampilan di Dashboard: Terbaru ke Terlama (Latest)
        $peminjaman = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.pinjam', compact('peminjaman', 'pendingLoans'));
    }

    // --- CETAK LAPORAN ---
    public function cetak(Request $request)
    {
        $query = Peminjaman::with(['user', 'item']);

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Role (Mahasiswa / Dosen)
        if ($request->filled('role')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        // Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // URUTAN KHUSUS CETAK: 
        // Berdasarkan 'tanggal_pinjam' dari yang TERLAMA (ASC)
        $peminjaman = $query->orderBy('tanggal_pinjam', 'asc')->get();

        return view('admin.peminjaman_cetak', compact('peminjaman'));
    }

    // --- FORM CREATE (TETAP SAMA) ---
    public function create()
    {
        $users = User::whereIn('role', ['mahasiswa', 'dosen'])->orderBy('name')->get();
        $items = Item::where('status_ketersediaan', 'Tersedia')->orderBy('nama_alat')->get();
        return view('admin.create_peminjaman', compact('users', 'items'));
    }

    // --- PROSES SIMPAN (TETAP SAMA) ---
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'amount' => 'required|integer|min:1', 
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'user_id' => 'nullable|exists:users,id', 
        ]);

        $targetUserId = $request->user_id ?? Auth::id();
        $item = Item::findOrFail($request->item_id);
        if ($item->stok_ready < $request->amount) {
            return back()->withErrors(['item_id' => 'Stok barang tidak mencukupi.'])->withInput();
        }

        Peminjaman::create([
            'user_id' => $targetUserId,
            'item_id' => $request->item_id,
            'amount' => $request->amount,
            'kode_peminjaman' => 'LOAN-' . $targetUserId . '-' . time(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending', 
            'alasan' => $request->input('alasan', 'Peminjaman Manual'),
        ]);

        if (Auth::user()->role == 'admin') {
            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil ditambahkan.');
        }
        return redirect()->route('student.loans')->with('success', 'Pengajuan berhasil!');
    }

    // --- UPDATE STATUS (LOGIKA MASSAL) ---
    public function update(Request $request, $id)
    {
        $loan = Peminjaman::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,dikembalikan'
        ]);

        if (in_array($request->status, ['disetujui', 'ditolak']) && $loan->kode_peminjaman) {
            
            Peminjaman::where('kode_peminjaman', $loan->kode_peminjaman)
                      ->where('status', 'pending') 
                      ->update([
                          'status' => $request->status,
                          'approver_id' => Auth::id()
                      ]);

            $msg = 'Seluruh permintaan dalam kode ' . $loan->kode_peminjaman . ' berhasil diproses.';

        } else {
            $loan->update([
                'status' => $request->status,
                'approver_id' => Auth::id()
            ]);
            $msg = 'Status item diperbarui.';
        }

        return back()->with('success', $msg);
    }
}