<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    // 1. TAMPILKAN DATA (DENGAN FILTER & SEARCH)
    public function index(Request $request)
    {
        // Mulai Query
        $query = User::query();

        // A. Logika Filter Role (Mahasiswa/Dosen)
        if ($request->has('role') && in_array($request->role, ['mahasiswa', 'dosen'])) {
            $query->where('role', $request->role);
        }

        // B. Logika Search (Pencarian) - BAGIAN INI YANG PENTING
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('identity_number', 'LIKE', "%{$search}%") // NIM atau NIP
                  ->orWhere('contact', 'LIKE', "%{$search}%");       // No HP
            });
        }

        // Ambil data (urutkan terbaru)
        $members = $query->latest()->get();

        // Kembalikan ke View
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
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|string|email|max:255|unique:users',
            'identity_number' => 'required|string|max:20|unique:users',
            'contact'         => 'nullable|string|max:15',
            'password'        => 'required|string|min:6',
            'role'            => 'required|in:mahasiswa,dosen',
        ]);

        User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'identity_number' => $request->identity_number,
            'contact'         => $request->contact,
            'password'        => Hash::make($request->password),
            'role'            => $request->role,
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
            'email'           => 'required|email|unique:users,email,' . $member->id,
            'identity_number' => 'required|string|size:8|unique:users,identity_number,' . $member->id,
            'contact'         => [
                'nullable', 'numeric', 'digits_between:10,13', 'regex:/^08[0-9]+$/', 
                'unique:users,contact,' . $member->id
            ],
            'password'        => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name'            => $request->name,
            'email'           => $request->email,
            'identity_number' => $request->identity_number,
            'contact'         => $request->contact,
            'role'            => $request->role,
        ];

        $passwordChanged = false;
        $plainPassword = null;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $plainPassword = $request->password;
            $passwordChanged = true;
        }

        $member->update($data);

        if ($passwordChanged) {
            try {
                Mail::send('emails.password_changed', [
                    'user' => $member,
                    'plainPassword' => $plainPassword
                ], function ($message) use ($member) {
                    $message->to($member->email)
                            ->subject('Reset Password Oleh Admin - Lab PTIK');
                });
            } catch (\Exception $e) {
                Log::error("Gagal kirim email ke {$member->email}: " . $e->getMessage());
                return redirect()->route('members.index')
                    ->with('success', "Data {$member->name} diperbarui (Email notifikasi gagal terkirim).");
            }
        }

        return redirect()->route('members.index')->with('success', "Data {$member->name} berhasil diperbarui!");
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $member = User::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}