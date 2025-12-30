<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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

        // 1. Validasi Ketat (Sama seperti ProfileController)
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $member->id,
            'identity_number' => 'required|string|size:8|unique:users,identity_number,' . $member->id,
            'contact'         => [
                'nullable', 'numeric', 'digits_between:10,13', 'regex:/^08[0-9]+$/', 
                'unique:users,contact,' . $member->id
            ],
            // Password opsional, tapi jika diisi WAJIB konfirmasi
            'password'        => 'nullable|min:6|confirmed',
        ], [
            'identity_number.size'   => 'NIM/NIP harus 8 digit.',
            'contact.regex'          => 'Format HP harus diawali 08.',
            'password.confirmed'     => 'Konfirmasi password baru tidak cocok.',
        ]);

        // 2. Siapkan Data Update
        $data = [
            'name'            => $request->name,
            'email'           => $request->email,
            'identity_number' => $request->identity_number,
            'contact'         => $request->contact,
            'role'            => $request->role, // Admin berhak ganti role
        ];

        $passwordChanged = false;
        $plainPassword = null;

        // 3. Cek Password Baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $plainPassword = $request->password;
            $passwordChanged = true;
        }

        // 4. Update Database
        $member->update($data);

        // 5. Kirim Email Notifikasi (Jika Password Berubah)
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
                // Log error tapi jangan gagalkan proses update
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