<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $rawPending = Peminjaman::with(['user', 'item'])
                        ->where('status', 'pending')
                        ->orderBy('created_at', 'asc')
                        ->get();

        $pendingLoans = $rawPending->groupBy('kode_peminjaman');
        $query = Peminjaman::with(['user', 'item'])
                    ->where('status', '!=', 'pending');
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('role')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        $allHistory = $query->orderBy('created_at', 'desc')->get();
        $groupedHistory = $allHistory->groupBy(function ($item) {
            return $item->kode_peminjaman . '|' . $item->tanggal_pinjam . '|' . $item->user_id;
        });
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $groupedHistory->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $peminjaman = new LengthAwarePaginator($currentItems, $groupedHistory->count(), $perPage);
        $peminjaman->setPath($request->url());
        $peminjaman->appends($request->all());
        
        return view('admin.pinjam', compact('peminjaman', 'pendingLoans')); 
    }

    public function cetak(Request $request)
    {
        $query = Peminjaman::with(['user', 'item'])
                    ->where('status', '!=', 'pending');

        if (!$request->filled('status')) {
            $query->whereIn('status', ['disetujui', 'terlambat']);
        } elseif ($request->status != 'semua') {
            $query->where('status', $request->status);
        }
        if ($request->filled('role')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('role', $request->role);
            });
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'asc')->get();

        return view('admin.peminjaman_cetak', compact('peminjaman'));
    }

    public function create()
    {
        $users = User::whereIn('role', ['mahasiswa', 'dosen'])->orderBy('name')->get();
        $items = Item::where('status_ketersediaan', 'Tersedia')->orderBy('nama_alat')->get();
        return view('admin.create_peminjam', compact('users', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'           => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.amount'  => 'required|integer|min:1',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'user_id'         => 'nullable|exists:users,id',
            'alasan'          => 'nullable|string'
        ]);

        $targetUserId = $request->user_id ?? Auth::id();
        $kodePeminjaman = 'LOAN-' . $targetUserId . '-' . time();
        $alasan = $request->input('alasan', 'Peminjaman Manual');

        foreach ($request->items as $itemData) {
            $itemDB = Item::find($itemData['item_id']);
            if (!$itemDB || $itemDB->stok_ready < $itemData['amount']) {
                $namaBarang = $itemDB ? $itemDB->nama_alat : 'Barang tidak dikenal';
                return back()->withErrors(['items' => "Stok '{$namaBarang}' tidak cukup!"])->withInput();
            }
        }

        $statusAwal = (Auth::user()->role == 'admin') ? 'disetujui' : 'pending';

        foreach ($request->items as $itemData) {
            Peminjaman::create([
                'user_id'         => $targetUserId,
                'item_id'         => $itemData['item_id'],
                'amount'          => $itemData['amount'],
                'kode_peminjaman' => $kodePeminjaman,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status'          => $statusAwal, 
                'alasan'          => $alasan,
                'approver_id'     => (Auth::user()->role == 'admin') ? Auth::id() : null,
            ]);
        }

        if (Auth::user()->role == 'admin') {
            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil dicatat.');
        }
        return redirect()->route('student.loans')->with('success', 'Pengajuan berhasil dikirim!');
    }

    public function update(Request $request, $id)
    {
        $loan = Peminjaman::findOrFail($id);
        $request->validate(['status' => 'required|in:disetujui,ditolak,dikembalikan']);

        $loansToUpdate = Peminjaman::where('kode_peminjaman', $loan->kode_peminjaman)->get();
        
        foreach ($loansToUpdate as $l) {
            $l->update([
                'status' => $request->status,
                'approver_id' => Auth::id()
            ]);
        }

        return back()->with('success', 'Status peminjaman berhasil diperbarui!');
    }
}