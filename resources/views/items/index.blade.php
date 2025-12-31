@extends('layouts.app')

@section('content')
{{-- Style Khusus --}}
<style>
    /* 1. Animasi Masuk */
    @keyframes fadeInUp {
        from { opacity: 0; margin-top: 20px; }
        to { opacity: 1; margin-top: 0; }
    }
    .animate-row {
        opacity: 0;
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    /* 2. Tooltip Kecil (Kode Alat & Tombol) */
    .custom-tooltip-container {
        position: relative;
        display: inline-block;
    }
    .custom-tooltip-text {
        visibility: hidden;
        width: max-content;
        max-width: 250px;
        background-color: #1f2937;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 6px 10px;
        position: absolute;
        z-index: 50;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%) scale(0.95);
        opacity: 0;
        transition: all 0.2s ease-in-out;
        font-size: 0.75rem;
        pointer-events: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .custom-tooltip-text::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #1f2937 transparent transparent transparent;
    }
    .custom-tooltip-container:hover .custom-tooltip-text {
        visibility: visible;
        opacity: 1;
        transform: translateX(-50%) scale(1);
    }

    /* 3. Modern Tooltip (POPUP DESKRIPSI) - FIX POSISI TENGAH LAYAR (VIEWPORT) */
    .item-container {
        position: relative; 
        display: inline-block;
    }
    
    .modern-tooltip {
        visibility: hidden;
        opacity: 0;
        
        /* POSISI FIXED: Selalu di tengah layar monitor (Viewport) */
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.90);
        
        /* TAMPILAN */
        width: 350px; 
        max-width: 90vw;
        background: rgba(30, 30, 40, 0.98); 
        color: #fff;
        padding: 24px;
        border-radius: 12px;
        font-size: 0.9rem;
        line-height: 1.6;
        z-index: 10000; /* Paling Depan */
        
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        pointer-events: none; 
        border: 1px solid rgba(255,255,255,0.15);
    }
    
    .modern-tooltip::before {
        display: none;
    }

    /* Efek Hover */
    .item-container:hover .modern-tooltip {
        visibility: visible;
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }

    /* Helper Classes */
    .tooltip-right .custom-tooltip-text { left: auto; right: 0; transform: translateX(0) scale(0.95); }
    .tooltip-right:hover .custom-tooltip-text { transform: translateX(0) scale(1); }
    .tooltip-right .custom-tooltip-text::after { left: auto; right: 15%; }
</style>

<div class="w-full">
    
    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mb-6 animate-row">
        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400 mr-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 relative">
        
        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-8 flex flex-col md:flex-row justify-between items-center text-white rounded-t-2xl">
            <div class="mb-4 md:mb-0">
                <h2 class="text-3xl font-extrabold tracking-tight">Daftar Inventaris Laboratorium</h2>
                <p class="text-pink-100 text-sm mt-1 opacity-90">
                    Kelola seluruh aset, alat, dan bahan praktikum dalam satu tempat.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                {{-- TOMBOL CETAK LAPORAN (UPDATED: Mengarah ke route cetak) --}}
                <a href="{{ route('barang.cetak') }}" target="_blank" class="group inline-flex items-center justify-center px-5 py-3 border border-pink-200 text-sm font-bold rounded-full text-white bg-white/20 hover:bg-white/30 focus:outline-none transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Laporan
                </a>

                {{-- Tombol Tambah --}}
                <a href="{{ route('barang.create') }}" class="group inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-full text-lab-pink-btn bg-white shadow-lg hover:bg-gray-50 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2 -ml-1 text-lab-pink-btn group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Barang Baru
                </a>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="px-8 py-6 border-b border-gray-100 bg-white">
            <form action="{{ route('items.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Cari Barang</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama alat atau kode..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Ketersediaan</label>
                        <select name="status" class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-lg text-sm focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                            <option value="">Semua Status</option>
                            <option value="Stok_Habis" {{ request('status') == 'Stok_Habis' ? 'selected' : '' }}>Stok Habis (0)</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg text-sm transition shadow-md">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- INFO BAR --}}
        <div class="px-8 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Total Aset: {{ count($items) }} Item
            </div>
            <div class="flex space-x-1.5 opacity-50">
                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                <div class="w-3 h-3 rounded-full bg-green-400"></div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="overflow-x-auto rounded-b-2xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-yellow-600 uppercase tracking-wider">Dipinjam</th>
                        <th scope="col" class="px-4 py-4 text-center text-xs font-bold text-green-600 uppercase tracking-wider">Tersedia</th>
                        <th scope="col" class="px-8 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($items as $index => $item)
                    <tr class="group hover:bg-pink-50 transition-colors duration-200 animate-row">
                        
                        {{-- Nama & Deskripsi --}}
                        <td class="px-8 py-5 whitespace-nowrap relative">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-pink-100 to-purple-100 rounded-lg flex items-center justify-center text-lab-pink-btn font-bold text-lg shadow-sm">
                                    {{ substr($item->nama_alat, 0, 1) }}
                                </div>
                                
                                {{-- AREA HOVER --}}
                                <div class="ml-4 item-container cursor-help z-10">
                                    <div class="text-sm font-bold text-gray-900 border-b border-dashed border-gray-300 hover:border-lab-pink-btn transition-colors inline-block">{{ $item->nama_alat }}</div>
                                    
                                    <div class="text-xs text-gray-500 mt-0.5 max-w-[400px] truncate">
                                        {{ \Illuminate\Support\Str::words($item->deskripsi, 10, '...') ?? 'Tidak ada deskripsi' }}
                                    </div>

                                    {{-- POPUP DESKRIPSI (FULL TEXT) --}}
                                    <div class="modern-tooltip text-left">
                                        <div class="flex items-center mb-3 pb-2 border-b border-gray-600">
                                            <svg class="w-5 h-5 mr-2 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="font-bold text-pink-100 text-xs uppercase tracking-wide">Detail Barang</span>
                                        </div>
                                        <div class="text-gray-200 mb-0 whitespace-normal">
                                            <strong class="text-white block mb-1 text-sm">{{ $item->nama_alat }}</strong>
                                            {{ $item->deskripsi ?? 'Belum ada deskripsi spesifikasi untuk alat ini.' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Kode Alat --}}
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="custom-tooltip-container">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-md bg-gray-50 text-gray-600 font-mono border border-gray-200 group-hover:bg-white group-hover:border-pink-200 transition-colors">
                                    {{ $item->kode_alat }}
                                </span>
                                <span class="custom-tooltip-text">Kode Inventaris Unik</span>
                            </div>
                        </td>

                        {{-- Rincian Stok --}}
                        <td class="px-4 py-5 whitespace-nowrap text-center">
                            <span class="text-sm font-bold text-gray-900">{{ $item->jumlah_total }}</span>
                        </td>

                        <td class="px-4 py-5 whitespace-nowrap text-center">
                            @if($item->stok_dipinjam > 0)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                                    {{ $item->stok_dipinjam }}
                                </span>
                            @else
                                <span class="text-xs text-gray-300 font-bold">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-5 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $item->stok_ready > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $item->stok_ready }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center space-x-3">
                                <div class="custom-tooltip-container tooltip-right">
                                    <a href="{{ route('barang.edit', $item->id) }}" class="text-indigo-500 hover:text-indigo-900 p-2 hover:bg-indigo-50 rounded-full transition duration-150 block">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <span class="custom-tooltip-text">Edit Barang</span>
                                </div>

                                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="contents" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <div class="custom-tooltip-container tooltip-right">
                                        <button type="submit" class="text-red-500 hover:text-red-900 p-2 hover:bg-red-50 rounded-full transition duration-150 block">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <span class="custom-tooltip-text bg-red-800">Hapus Permanen</span>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-gray-500 bg-gray-50 animate-row">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="text-lg font-medium text-gray-600">Belum ada data barang.</p>
                                <p class="text-sm mt-1">Silakan tambahkan barang inventaris baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection