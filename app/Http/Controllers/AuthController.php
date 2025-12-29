<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- LOGIN ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek Kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role (mahasiswa/dosen ke dashboard student)
            if (in_array(Auth::user()->role, ['mahasiswa', 'dosen'])) {
                return redirect()->route('student.dashboard');
            }
            
            // Jika bukan keduanya (berarti Admin), ke dashboard admin
            return redirect()->route('dashboard_admin');
        }

        // 3. Jika Gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- REGISTER ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerProses(Request $request)
    {
        // 1. Validasi Dasar (Hanya Mahasiswa & Dosen)
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:mahasiswa,dosen', // Admin dihapus dari validasi ini
        ]);

        // 2. Tentukan Identity Number (NIM/NIP)
        $identityNumber = null;
        $role = $request->role;

        if ($role === 'mahasiswa') {
            $request->validate(['identity_number_mhs' => 'required']);
            $identityNumber = $request->identity_number_mhs;
            
        } elseif ($role === 'dosen') {
            $request->validate(['identity_number_dosen' => 'required']);
            $identityNumber = $request->identity_number_dosen;
        }

        // 3. Simpan User ke Database
        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $role,
            'identity_number' => $identityNumber,
        ];

        User::create($data);

        // 4. Login Otomatis & Redirect
        $loginData = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($loginData)) {
            $request->session()->regenerate();
            // Karena hanya Mhs & Dosen, redirect ke User Dashboard semua
            return redirect()->route('user.dashboard');
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
