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
        $rawPending = Peminjaman::with(['user', 'item'])
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'asc')
                        ->get();

        // 1. DATA PENDING (DIKELOMPOKKAN BERDASARKAN KODE PEMINJAMAN)
        $pendingLoans = $rawPending->groupBy('kode_peminjaman');
        
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

    // --- FORM PEMINJAMAN ---
    public function create()
    {
        $users = User::whereIn('role', ['mahasiswa', 'dosen'])->orderBy('name')->get();
        $items = Item::where('status_ketersediaan', 'Tersedia')->orderBy('nama_alat')->get();
        
        return view('admin.create_peminjam', compact('users', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'           => 'required|array|min:1', // Wajib ada minimal 1 barang
            'items.*.item_id' => 'required|exists:items,id', // Tiap item harus valid
            'items.*.amount'  => 'required|integer|min:1',   // Tiap jumlah harus valid
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'user_id'         => 'nullable|exists:users,id', // Untuk Admin
            'alasan'          => 'nullable|string'
        ]);

        $targetUserId = $request->user_id ?? Auth::id();
        
        $kodePeminjaman = 'LOAN-' . $targetUserId . '-' . time();
        $alasan = $request->input('alasan', 'Peminjaman Manual');

        // 2. CEK STOK TERSEDIA (Looping Pertama)
        foreach ($request->items as $itemData) {
            $itemDB = Item::find($itemData['item_id']);
            
            if (!$itemDB || $itemDB->stok_ready < $itemData['amount']) {
                $namaBarang = $itemDB ? $itemDB->nama_alat : 'Barang tidak dikenal';
                return back()
                    ->withErrors(['items' => "Stok barang '{$namaBarang}' tidak mencukupi."])
                    ->withInput();
            }
        }

        // 3. SIMPAN DATA 
        foreach ($request->items as $itemData) {
            Peminjaman::create([
                'user_id'         => $targetUserId,
                'item_id'         => $itemData['item_id'],
                'amount'          => $itemData['amount'],
                'kode_peminjaman' => $kodePeminjaman,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status'          => 'pending', 
                'alasan'          => $alasan,
            ]);
        }

        // 4. REDIRECT SESUAI ROLE
        if (Auth::user()->role == 'admin') {
            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil dicatat.');
        }
        return redirect()->route('student.loans')->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

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