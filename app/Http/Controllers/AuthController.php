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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (in_array(Auth::user()->role, ['mahasiswa', 'dosen'])) {
                return redirect()->route('student.dashboard');
            }
            return redirect()->route('dashboard_admin');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- REGISTER ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:users,name',
            'email'    => 'required|email|unique:users,email',
        
            'contact'  => [
                'required',
                'numeric',
                'digits_between:10,13',
                'regex:/^08[0-9]+$/',
                'unique:users,contact'
            ],
            
            'password' => 'required|min:6',
            'role'     => 'required|in:mahasiswa,dosen',
        ], [
            'name.unique'             => 'Nama ini sudah terdaftar.',
            'email.unique'            => 'Email Ini sudah digunakan.',
            'contact.required'        => 'Nomor WhatsApp/HP wajib diisi.',
            'contact.numeric'         => 'Nomor WhatsApp/HP harus berupa angka.',
            'contact.digits_between'  => 'Nomor WhatsApp/HP tidak valid (Harus 10-13 digit).',
            'contact.regex'           => 'Format nomor tidak valid. Harus diawali "08" (Contoh: 0812345...).',
            'contact.unique'          => 'Nomor WhatsApp/HP ini sudah terdaftar.',
            'password.min'            => 'Password minimal 6 karakter.',
        ]);
        $identityNumber = null;
        $role = $request->role;

        if ($role === 'mahasiswa') {
            $request->validate([
                'identity_number_mhs' => 'required|string|size:8|unique:users,identity_number'
            ], [
                'identity_number_mhs.required' => 'NIM wajib diisi.',
                'identity_number_mhs.size'     => 'Format NIM salah (Wajib 8 digit/karakter).',
                'identity_number_mhs.unique'   => 'NIM ini sudah terdaftar sebelumnya.',
            ]);
            
            $identityNumber = $request->identity_number_mhs;
            
        } elseif ($role === 'dosen') {
            $request->validate([
                'identity_number_dosen' => 'required|string|min:8|unique:users,identity_number'
            ], [
                'identity_number_dosen.required' => 'NIP wajib diisi.',
                'identity_number_dosen.min'      => 'NIP terlalu pendek (Minimal 8 digit).',
                'identity_number_dosen.unique'   => 'NIP ini sudah terdaftar.',
            ]);
            
            $identityNumber = $request->identity_number_dosen;
        }

        $user = User::create([
            'name'            => $request->name,
            'email'           => $request->email,
            'contact'         => $request->contact,
            'password'        => Hash::make($request->password),
            'role'            => $role,
            'identity_number' => $identityNumber,
        ]);
        Auth::login($user);
                return redirect()->route('student.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
