@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 mt-6">
        
        <div class="bg-lab-pink-dark px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Anggota
            </h2>
        </div>

        <form action="{{ route('members.update', $member->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT') {{-- PENTING UNTUK UPDATE --}}

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                {{-- NIM --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">NIM</label>
                    <input type="text" name="identity_number" value="{{ old('identity_number', $member->identity_number) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" required>
                </div>
                {{-- No HP --}}
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">No. HP / WhatsApp</label>
                    <input type="text" name="contact" value="{{ old('contact', $member->contact) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn">
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" required>
            </div>

            {{-- Password (Opsional) --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password Baru (Opsional)</label>
                <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-lab-pink-btn" placeholder="Biarkan kosong jika tidak ingin mengganti">
                <p class="text-xs text-gray-500 mt-1">* Isi hanya jika ingin mereset password anggota ini.</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('members.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-lab-pink-btn text-white rounded-lg hover:bg-pink-700 transition font-semibold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection