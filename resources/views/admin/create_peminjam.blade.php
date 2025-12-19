@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl py-8">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('peminjaman') }}" class="inline-flex items-center text-gray-500 hover:text-lab-pink-btn mb-6 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Data Peminjaman
    </a>

    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
        
        {{-- Header Form --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-6 text-white">
            <h2 class="text-2xl font-bold">Catat Peminjaman Baru</h2>
            <p class="text-pink-100 text-sm mt-1">Admin dapat mencatat peminjaman alat untuk mahasiswa di sini.</p>
        </div>

        {{-- Body Form --}}
        <div class="p-8">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf

                {{-- Pilih Mahasiswa (AUTOCOMPLETE / PENCARIAN) --}}
                <div class="mb-6 relative">
                    <label for="user_search" class="block text-sm font-semibold text-gray-700 mb-2">Peminjam (Mahasiswa)</label>
                    
                    {{-- Input Hidden: Ini yang akan dikirim ke database (ID User) --}}
                    {{-- WAJIB ADA agar Controller menerima 'user_id' --}}
                    <input type="hidden" name="user_id" id="user_id_input" required>

                    {{-- Input Teks: Ini hanya untuk tampilan dan pencarian --}}
                    <div class="relative">
                        <input type="text" id="user_search" 
                               class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-lab-pink-btn focus:border-lab-pink-btn sm:text-sm rounded-lg border shadow-sm" 
                               placeholder="Ketik nama mahasiswa..." autocomplete="off">
                        
                        {{-- Ikon Search --}}
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>

                    {{-- Container Hasil Pencarian (Dropdown Otomatis) --}}
                    <ul id="user_suggestions" class="absolute z-20 w-full bg-white border border-gray-200 rounded-lg shadow-xl mt-1 max-h-60 overflow-y-auto hidden">
                        {{-- List rekomendasi akan muncul di sini lewat JavaScript --}}
                    </ul>
                    
                    <p class="text-xs text-gray-500 mt-1">Mulai ketik nama untuk memunculkan rekomendasi.</p>
                    @error('user_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Pilih Barang (Tetap Select Dropdown) --}}
                <div class="mb-6">
                    <label for="item_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Alat / Barang</label>
                    <div class="relative">
                        <select name="item_id" id="item_id" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-lab-pink-btn focus:border-lab-pink-btn sm:text-sm rounded-lg border shadow-sm" required>
                            <option value="" disabled selected>-- Pilih Barang --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_alat }} (Stok: {{ $item->jumlah_total ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Grid Tanggal --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-semibold text-gray-700 mb-2">Rencana Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border" required min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                {{-- Keperluan --}}
                <div class="mb-8">
                    <label for="alasan" class="block text-sm font-semibold text-gray-700 mb-2">Keperluan (Opsional)</label>
                    <textarea name="alasan" id="alasan" rows="3" class="shadow-sm focus:ring-lab-pink-btn focus:border-lab-pink-btn mt-1 block w-full sm:text-sm border border-gray-300 rounded-lg p-3" placeholder="Contoh: Untuk keperluan praktikum..."></textarea>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit" class="bg-lab-pink-btn text-white px-6 py-3 rounded-full font-bold shadow hover:bg-pink-700 transition">
                        Simpan Data
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT UNTUK FITUR PENCARIAN --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Ambil data users dari Controller (PHP) dan ubah jadi JSON agar bisa dibaca JavaScript
        const users = @json($users); 

        const searchInput = document.getElementById('user_search');
        const hiddenInput = document.getElementById('user_id_input');
        const suggestionsBox = document.getElementById('user_suggestions');

        // 2. Fungsi saat mengetik
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase(); // Ambil teks dan kecilkan huruf
            suggestionsBox.innerHTML = ''; // Bersihkan list sebelumnya
            hiddenInput.value = ''; // Reset ID (biar user wajib klik pilihan)
            
            // Jika kosong, sembunyikan kotak rekomendasi
            if (query.length < 1) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            // 3. Filter Data Mahasiswa
            const filteredUsers = users.filter(user => 
                // Cari berdasarkan Nama ATAU Email
                user.name.toLowerCase().includes(query) || 
                (user.email && user.email.toLowerCase().includes(query))
            );

            // 4. Tampilkan Hasil
            if (filteredUsers.length > 0) {
                suggestionsBox.classList.remove('hidden');
                
                filteredUsers.forEach(user => {
                    // Buat elemen <li>
                    const li = document.createElement('li');
                    li.className = 'px-4 py-3 hover:bg-pink-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-0 flex justify-between items-center';
                    
                    // Isi teks (Nama tebal, email kecil)
                    li.innerHTML = `
                        <div>
                            <span class="font-bold block text-gray-800">${user.name}</span>
                            <span class="text-xs text-gray-500">${user.email || ''}</span>
                        </div>
                    `;
                    
                    // Saat diklik
                    li.addEventListener('click', () => {
                        searchInput.value = user.name; // Tampilkan nama di kotak pencarian
                        hiddenInput.value = user.id;   // Masukkan ID ke input hidden (PENTING)
                        suggestionsBox.classList.add('hidden'); // Tutup list
                    });

                    suggestionsBox.appendChild(li);
                });
            } else {
                // Jika tidak ditemukan
                suggestionsBox.classList.remove('hidden');
                suggestionsBox.innerHTML = '<li class="px-4 py-3 text-sm text-gray-500 italic">Tidak ada mahasiswa ditemukan.</li>';
            }
        });

        // 5. Tutup rekomendasi jika klik di luar area input
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
            }
        });
    });
</script>
@endsection