<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * MENAMPILKAN DAFTAR (Dengan Fitur Search & Filter Cerdas)
     */
    public function index(Request $request)
    {
        // 1. Mulai Query Dasar
        $query = Item::query();

        // 2. Logika PENCARIAN (Search Bar)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'LIKE', '%' . $search . '%')
                  ->orWhere('kode_alat', 'LIKE', '%' . $search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $search . '%');
            });
        }

        // 3. Ambil Data (Urutkan nama A-Z)
        // Kita ambil data dulu dengan get(), baru difilter manual di bawah
        $items = $query->orderBy('nama_alat', 'asc')->get();

        // 4. Logika FILTER STATUS (PHP Collection Filter)
        // Kita filter manual menggunakan PHP agar tidak error "Column not found"
        if ($request->filled('status') && $request->status == 'Stok_Habis') {
            $items = $items->filter(function ($item) {
                // Hitung stok ready secara manual: Total - Dipinjam
                // Gunakan operator ?? 0 untuk jaga-jaga jika kolom stok_dipinjam null/tidak ada
                $dipinjam = $item->stok_dipinjam ?? 0;
                $ready = $item->jumlah_total - $dipinjam;

                // Ambil barang yang sisa stoknya 0 atau kurang
                return $ready <= 0;
            });
        }

        // 5. Kirim ke View
        return view('items.index', compact('items'));
    }

    /**
     * FUNGSI CETAK LAPORAN
     * Mengarahkan ke file item_cetak.blade.php
     */
    public function cetak()
    {
        // Ambil data urut abjad untuk laporan
        $items = Item::orderBy('nama_alat', 'asc')->get();
        
        // Arahkan ke view khusus cetak
        return view('items.item_cetak', compact('items'));
    }

    /**
     * MENAMPILKAN FORM DENGAN KODE OTOMATIS
     */
    public function create()
    {
        // Generate Kode: LAB-TAHUN-ACAK
        $kodeOtomatis = 'LAB-' . date('Y') . '-' . strtoupper(Str::random(4));
        return view('items.create_barang', compact('kodeOtomatis'));
    }

    /**
     * MENYIMPAN DATA
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|unique:items,kode_alat',
            'jumlah_total' => 'required|integer|min:0', 
            'deskripsi' => 'nullable|string',
        ]);

        // Inisialisasi Stok Dipinjam 0
        $validated['stok_dipinjam'] = 0;
        
        // CATATAN: Kita HAPUS penyimpanan 'stok_ready' karena kolomnya tidak ada di DB.
        // Stok ready sebaiknya dihitung otomatis (Total - Dipinjam) di View.

        // Tentukan Status Label (Opsional, untuk display saja)
        if ($request->jumlah_total == 0) {
            $validated['status_ketersediaan'] = 'Habis'; 
        } else {
            $validated['status_ketersediaan'] = 'Tersedia';
        }

        Item::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Menampilkan Form Edit
    public function edit($id)
    {
        $barang = Item::findOrFail($id);
        return view('items.edit_barang', compact('barang'));
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $barang = Item::findOrFail($id);

        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|unique:items,kode_alat,'.$barang->id, 
            'jumlah_total' => 'required|integer|min:0',
            'status_ketersediaan' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        // Hapus logika update 'stok_ready' karena kolom tidak ada.
        // Cukup update jumlah_total saja.
        
        // Cek validasi sederhana agar stok tidak minus saat diedit
        $dipinjamSaatIni = $barang->stok_dipinjam ?? 0;
        if ($request->jumlah_total < $dipinjamSaatIni) {
             return back()->withErrors(['jumlah_total' => 'Jumlah total tidak boleh lebih kecil dari jumlah yang sedang dipinjam (' . $dipinjamSaatIni . ')']);
        }

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $barang = Item::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}