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
        // 1. Validasi Input (Email & Password wajib diisi)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek apakah email & password cocok dengan database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // 3. Jika cocok, lempar user ke halaman Dashboard (/)
            return redirect()->intended('/');
        }

        // 4. Jika salah, kembalikan ke halaman login dengan pesan error
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
        return redirect('/login');
    }
}