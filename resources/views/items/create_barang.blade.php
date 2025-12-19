@extends('layouts.app')

@section('content')
<div class="w-full">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('barang.index') }}" class="inline-flex items-center text-gray-500 hover:text-lab-pink-btn mb-6 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Inventaris
    </a>

    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
        
        {{-- Header Form --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-6 text-white">
            <h2 class="text-2xl font-bold">Tambah Barang Baru</h2>
            <p class="text-pink-100 text-sm mt-1">Kode Inventaris dibuat otomatis. Silakan lengkapi detail alat.</p>
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

                {{-- GRID: Kode Alat (Readonly) & Jumlah Total --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    {{-- Kode Alat (Otomatis & Readonly) --}}
                    <div>
                        <label for="kode_alat" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode Alat <span class="text-xs font-normal text-gray-500">(Otomatis)</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="kode_alat" id="kode_alat" 
                                   value="{{ $kodeOtomatis }}" 
                                   readonly
                                   class="mt-1 block w-full shadow-sm sm:text-sm border-gray-200 rounded-lg py-3 px-4 border bg-gray-100 text-gray-500 cursor-not-allowed font-mono tracking-wider">
                            
                            {{-- Ikon Gembok (Opsional, untuk memperjelas readonly) --}}
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
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