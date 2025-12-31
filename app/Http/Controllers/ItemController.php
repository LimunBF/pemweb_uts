<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'LIKE', '%' . $search . '%')
                  ->orWhere('kode_alat', 'LIKE', '%' . $search . '%')
                  ->orWhere('deskripsi', 'LIKE', '%' . $search . '%');
            });
        }
        $items = $query->orderBy('nama_alat', 'asc')->get();
        if ($request->filled('status') && $request->status == 'Stok_Habis') {
            $items = $items->filter(function ($item) {
                $dipinjam = $item->stok_dipinjam ?? 0;
                $ready = $item->jumlah_total - $dipinjam;
                return $ready <= 0;
            });
        }

        return view('items.index', compact('items'));
    }

    public function cetak()
    {
        $items = Item::orderBy('nama_alat', 'asc')->get();
        return view('items.item_cetak', compact('items'));
    }

    public function create()
    {
        $kodeOtomatis = 'LAB-' . date('Y') . '-' . strtoupper(Str::random(4));
        return view('items.create_barang', compact('kodeOtomatis'));
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|unique:items,kode_alat',
            'jumlah_total' => 'required|integer|min:0', 
            'deskripsi' => 'nullable|string',
        ]);

        $validated['stok_dipinjam'] = 0;
        if ($request->jumlah_total == 0) {
            $validated['status_ketersediaan'] = 'Habis'; 
        } else {
            $validated['status_ketersediaan'] = 'Tersedia';
        }

        Item::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $barang = Item::findOrFail($id);
        return view('items.edit_barang', compact('barang'));
    }

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

        $dipinjamSaatIni = $barang->stok_dipinjam ?? 0;
        if ($request->jumlah_total < $dipinjamSaatIni) {
             return back()->withErrors(['jumlah_total' => 'Jumlah total tidak boleh lebih kecil dari jumlah yang sedang dipinjam (' . $dipinjamSaatIni . ')']);
        }

        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Item::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}