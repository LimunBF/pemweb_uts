<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // 1. TAMPILKAN DATA
    public function index()
    {
        $members = User::where('role', 'mahasiswa')->latest()->get();
        return view('members.index', compact('members'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        return view('members.create');
    }

    // 3. SIMPAN DATA BARU
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'identity_number' => 'required|string|max:20|unique:users', // NIM
            'contact'         => 'nullable|string|max:15',
            'password'        => 'required|string|min:6',
        ]);

        // Simpan ke Database
        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'identity_number' => $request->identity_number,
            'contact'         => $request->contact,
            'password'        => Hash::make($request->password), // Enkripsi password
            'role'            => 'mahasiswa', // Otomatis set sebagai mahasiswa
        ]);

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $member = User::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        $member = User::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            // Validasi unique kecuali untuk user ini sendiri
            'email'           => 'required|email|unique:users,email,' . $member->id,
            'identity_number' => 'required|string|unique:users,identity_number,' . $member->id,
            'contact'         => 'nullable|string|max:15',
            'password'        => 'nullable|string|min:6', // Password boleh kosong jika tidak ingin diganti
        ]);

        // Data yang akan diupdate
        $data = [
            'name'            => $request->name,
            'email'           => $request->email,
            'identity_number' => $request->identity_number,
            'contact'         => $request->contact,
        ];

        // Cek jika password diisi, maka update password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $member = User::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}