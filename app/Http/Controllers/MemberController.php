<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role') && in_array($request->role, ['mahasiswa', 'dosen'])) {
            $query->where('role', $request->role);
        }

        $members = $query->latest()->get();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

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

    public function edit($id)
    {
        $member = User::findOrFail($id);
        return view('members.edit', compact('member'));
    }

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

    public function destroy($id)
    {
        $member = User::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus!');
    }
}