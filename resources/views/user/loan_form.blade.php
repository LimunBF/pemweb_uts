@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-3xl">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('student.dashboard') }}" class="inline-flex items-center text-gray-500 hover:text-lab-pink-btn mb-6 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Dashboard
    </a>

    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
        
        {{-- Header Form --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-6 text-white">
            <h2 class="text-2xl font-bold">Formulir Pengajuan Peminjaman</h2>
            <p class="text-pink-100 text-sm mt-1">Silakan lengkapi data di bawah ini untuk meminjam alat.</p>
        </div>

        {{-- Body Form --}}
        <div class="p-8">
            <form action="{{ route('student.loan.store') }}" method="POST">
                @csrf

                {{-- Pilih Barang --}}
                <div class="mb-6">
                    <label for="item_id" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Alat / Barang</label>
                    <div class="relative">
                        <select name="item_id" id="item_id" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-lab-pink-btn focus:border-lab-pink-btn sm:text-sm rounded-lg border shadow-sm" required>
                            <option value="" disabled selected>-- Pilih Barang yang Tersedia --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->nama_alat }} (Stok Ready: {{ $item->stok_ready }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    @error('item_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Grid Tanggal --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="tanggal_pinjam" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai Pinjam</label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" 
                               class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border" 
                               required min="{{ date('Y-m-d') }}">
                        @error('tanggal_pinjam') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-semibold text-gray-700 mb-2">Rencana Pengembalian</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" 
                               class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border" 
                               required min="{{ date('Y-m-d') }}">
                        @error('tanggal_kembali') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Keperluan (Opsional tapi bagus ada) --}}
                <div class="mb-8">
                    <label for="alasan" class="block text-sm font-semibold text-gray-700 mb-2">Keperluan Peminjaman (Opsional)</label>
                    <textarea name="alasan" id="alasan" rows="3" class="shadow-sm focus:ring-lab-pink-btn focus:border-lab-pink-btn mt-1 block w-full sm:text-sm border border-gray-300 rounded-lg p-3" placeholder="Contoh: Untuk praktikum mata kuliah Jaringan Komputer..."></textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end pt-6 border-t border-gray-100">
                    <button type="submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-lab-pink-btn hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-150">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Ajukan Peminjaman
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection