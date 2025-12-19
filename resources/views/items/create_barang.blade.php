@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('barang.index') }}" class="inline-flex items-center text-gray-500 hover:text-lab-pink-btn mb-6 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Inventaris
    </a>

    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
        
        {{-- Header Form --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-6 text-white">
            <h2 class="text-2xl font-bold">Tambah Barang Baru</h2>
            <p class="text-pink-100 text-sm mt-1">Isi formulir berikut sesuai dengan data alat laboratorium.</p>
        </div>

        {{-- Body Form --}}
        <div class="p-8">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf

                {{-- Nama Alat --}}
                <div class="mb-6">
                    <label for="nama_alat" class="block text-sm font-semibold text-gray-700 mb-2">Nama Alat</label>
                    <input type="text" name="nama_alat" id="nama_alat" 
                           class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border" 
                           placeholder="Contoh: Mikroskop Digital"
                           required>
                    @error('nama_alat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Grid: Kode Alat & Jumlah Total --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- Kode Alat --}}
                    <div>
                        <label for="kode_alat" class="block text-sm font-semibold text-gray-700 mb-2">Kode Alat</label>
                        <input type="text" name="kode_alat" id="kode_alat" 
                               class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border" 
                               placeholder="Contoh: LAB-BIO-001"
                               required>
                        @error('kode_alat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Jumlah Total --}}
                    <div>
                        <label for="jumlah_total" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Total</label>
                        <input type="number" name="jumlah_total" id="jumlah_total" min="1" value="1"
                               class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border" 
                               required>
                        @error('jumlah_total') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Alat</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3" 
                              class="shadow-sm focus:ring-lab-pink-btn focus:border-lab-pink-btn mt-1 block w-full sm:text-sm border border-gray-300 rounded-lg p-3" 
                              placeholder="Spesifikasi alat, kondisi fisik, dll..."></textarea>
                    @error('deskripsi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Status Ketersediaan --}}
                <div class="mb-8">
                    <label for="status_ketersediaan" class="block text-sm font-semibold text-gray-700 mb-2">Status Ketersediaan</label>
                    <div class="relative">
                        <select name="status_ketersediaan" id="status_ketersediaan" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-lab-pink-btn focus:border-lab-pink-btn sm:text-sm rounded-lg border shadow-sm">
                            <option value="Tersedia" selected>Tersedia</option>
                            <option value="Dipinjam">Dipinjam</option>
                            <option value="Perbaikan">Perbaikan</option>
                            <option value="Rusak">Rusak</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </div>
                    </div>
                    @error('status_ketersediaan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-lab-pink-btn hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-150">
                        Simpan Barang
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection