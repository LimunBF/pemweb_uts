@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 mt-6">
        
        <div class="bg-lab-pink-dark px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Anggota Baru
            </h2>
        </div>

        <form action="{{ route('members.store') }}" method="POST" class="p-6">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                {{-- NIM --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">NIM</label>
                    <input type="text" name="identity_number" value="{{ old('identity_number') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" required placeholder="Contoh: 12345678">
                </div>
                {{-- No HP --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">No. HP / WhatsApp</label>
                    <input type="text" name="contact" value="{{ old('contact') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" placeholder="08123xxxx">
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" required placeholder="email@mahasiswa.com">
            </div>

            {{-- Password --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password Akun</label>
                <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" required placeholder="Minimal 6 karakter">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('members.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-lab-pink-btn text-white rounded-lg hover:bg-pink-700 transition font-semibold">Simpan Anggota</button>
            </div>
        </form>
    </div>
</div>
@endsection