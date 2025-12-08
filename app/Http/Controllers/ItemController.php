<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Menampilkan daftar barang (Read)
     */
    public function index()
    {
        // Ambil semua data item, urutkan dari yang terbaru
        $items = Item::latest()->get();
        
        // Kirim ke view resources/views/items/index.blade.php
        return view('items.index', compact('items'));
    }

    /**
     * Menampilkan form tambah barang (Create View)
     */
    public function create()
    {
        // Pastikan kamu punya file resources/views/items/create.blade.php
        return view('items.create');
    }

    /**
     * Menyimpan barang baru ke database (Create Process)
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'nullable|string|unique:items,kode_alat',
            'jumlah_total' => 'required|integer|min:1',
            'status_ketersediaan' => 'required|string',
        ]);

        // 2. Simpan ke database
        Item::create($request->all());

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->route('items.index')
                         ->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu barang (Show - Opsional)
     */
    public function show(Item $item)
    {
        // return view('items.show', compact('item'));
    }

    /**
     * Menampilkan form edit barang (Edit View)
     */
    public function edit(Item $item)
    {
        // Pastikan kamu punya file resources/views/items/edit.blade.php
        return view('items.edit', compact('item'));
    }

    /**
     * Mengupdate data barang di database (Update Process)
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'kode_alat' => 'nullable|string',
            'jumlah_total' => 'required|integer|min:1',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')
                         ->with('success', 'Data barang berhasil diperbarui!');
    }

    /**
     * Menghapus barang (Delete Process)
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
                         ->with('success', 'Barang berhasil dihapus!');
    }
}