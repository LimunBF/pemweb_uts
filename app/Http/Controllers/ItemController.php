<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * MENAMPILKAN FORM DENGAN KODE OTOMATIS
     */
    public function create()
    {
        // 1. Generate Kode di sini agar bisa dilihat user
        $kodeOtomatis = 'LAB-' . date('Y') . '-' . strtoupper(Str::random(4));

        // 2. Kirim variabel $kodeOtomatis ke view
        return view('items.create_barang', compact('kodeOtomatis'));
    }

    /**
     * MENYIMPAN DATA (Menerima Kode dari Form)
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|unique:items,kode_alat', // Pastikan unik
            'jumlah_total' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        // Status default tetap otomatis 'Tersedia'
        $validated['status_ketersediaan'] = 'Tersedia';

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
            // Ignore unique check untuk barang ini sendiri
            'kode_alat' => 'required|string|unique:items,kode_alat,'.$barang->id, 
            'jumlah_total' => 'required|integer|min:1',
            'status_ketersediaan' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

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