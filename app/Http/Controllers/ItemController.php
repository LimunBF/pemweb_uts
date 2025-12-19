<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar barang (Index).
     */
    public function index()
    {
        $items = Item::all();
        // Pastikan file index ada di folder resources/views/items/index.blade.php
        return view('items.index', compact('items'));
    }

    /**
     * Menampilkan form tambah barang (Create).
     */
    public function create()
    {
        // Pastikan file create ada di folder resources/views/items/create_barang.blade.php
        return view('items.create_barang');
    }

    /**
     * Menyimpan data barang ke database (Store).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|unique:items,kode_alat',
            'jumlah_total' => 'required|integer|min:1',
            'status_ketersediaan' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        Item::create($validated);

        // Redirect ke route 'barang.index' agar sesuai dengan web.php
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit barang (Edit).
     */
    public function edit($id)
    {
        // Cari barang berdasarkan ID, jika tidak ketemu akan error 404
        $barang = Item::findOrFail($id);

        // Pastikan file edit ada di resources/views/items/edit_barang.blade.php
        return view('items.edit_barang', compact('barang'));
    }

    /**
     * Memperbarui data barang di database (Update).
     */
    public function update(Request $request, $id)
    {
        // Cari barang dulu
        $barang = Item::findOrFail($id);

        // Validasi (perhatikan pengecualian unique untuk kode_alat milik barang ini sendiri)
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'required|string|unique:items,kode_alat,'.$barang->id,
            'jumlah_total' => 'required|integer|min:1',
            'status_ketersediaan' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        // Update data
        $barang->update($validated);

        // Redirect kembali ke daftar barang
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    /**
     * Menghapus barang (Destroy) - Opsional jika dibutuhkan
     */
    public function destroy($id)
    {
        $barang = Item::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}