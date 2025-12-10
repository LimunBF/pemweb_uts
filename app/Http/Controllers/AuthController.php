<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function showLoginForm()
    {
        // Pastikan file view ada di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // 3. CEK ROLE & REDIRECT SESUAI HAK AKSES
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('dashboard_admin');
            } else {
                // Asumsi role selain admin adalah mahasiswa
                return redirect()->route('student.dashboard');
            }
        }

        // 4. Jika salah
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Setelah logout, kembali ke halaman login
        return redirect()->route('login');
    }
}