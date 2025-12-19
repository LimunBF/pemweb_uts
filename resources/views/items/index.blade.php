@extends('layouts.app')

@section('content')
{{-- Style Khusus untuk Animasi & Tooltip (Dari Desain Sebelumnya) --}}
<style>
    /* 1. Animasi Masuk (Fade In Up) */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-row {
        opacity: 0; /* Mulai hidden */
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    /* 2. Custom Tooltip Logic */
    .custom-tooltip-container {
        position: relative;
        display: inline-block;
    }
    .custom-tooltip-text {
        visibility: hidden;
        width: max-content;
        max-width: 250px;
        background-color: #1f2937; /* Gray-900 */
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 8px 12px;
        position: absolute;
        z-index: 50;
        bottom: 125%; /* Muncul di atas elemen */
        left: 50%;
        transform: translateX(-50%) scale(0.95);
        opacity: 0;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        font-size: 0.75rem;
        font-weight: 500;
        pointer-events: none;
    }
    /* Panah Tooltip */
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

    /* Modifikasi posisi tooltip agar tidak terpotong layar */
    .tooltip-left .custom-tooltip-text {
        left: 0; transform: translateX(0) scale(0.95);
    }
    .tooltip-left:hover .custom-tooltip-text { transform: translateX(0) scale(1); }
    .tooltip-left .custom-tooltip-text::after { left: 15%; }

    .tooltip-right .custom-tooltip-text {
        left: auto; right: 0; transform: translateX(0) scale(0.95);
    }
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

    {{-- CONTAINER UTAMA (Menyatu seperti desain terbaru) --}}
    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden">
        
        {{-- HEADER GRADIENT (Menyatu di dalam) --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-8 flex flex-col md:flex-row justify-between items-center text-white">
            <div class="mb-4 md:mb-0">
                <h2 class="text-3xl font-extrabold tracking-tight">Daftar Inventaris Laboratorium</h2>
                <p class="text-pink-100 text-sm mt-1 opacity-90">
                    Kelola seluruh aset, alat, dan bahan praktikum dalam satu tempat.
                </p>
            </div>
            
            {{-- Tombol Tambah (Putih Kontras) --}}
            <a href="{{ route('barang.create') }}" class="group inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-full text-lab-pink-btn bg-white shadow-lg hover:bg-gray-50 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-300 transform hover:-translate-y-1">
                <svg class="w-5 h-5 mr-2 -ml-1 text-lab-pink-btn group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Barang Baru
            </a>
        </div>

        {{-- TOOLBAR INFO --}}
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

        {{-- TABEL KAYA FITUR (Tooltip & Animasi dari Desain Sebelumnya) --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-8 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-8 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($items as $index => $item)
                    {{-- Animasi Staggered Row --}}
                    <tr class="group hover:bg-pink-50 transition-all duration-300 transform hover:scale-[1.002] animate-row" style="animation-delay: {{ 0.1 + ($index * 0.05) }}s;">
                        
                        {{-- Nama & Deskripsi --}}
                        <td class="px-8 py-5 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-pink-100 to-purple-100 rounded-lg flex items-center justify-center text-lab-pink-btn font-bold text-lg shadow-sm">
                                    {{ substr($item->nama_alat, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $item->nama_alat }}</div>
                                    
                                    {{-- Tooltip Deskripsi --}}
                                    <div class="custom-tooltip-container tooltip-left">
                                        <div class="text-xs text-gray-500 cursor-help border-b border-dashed border-gray-300 inline-block pb-0.5 max-w-[200px] truncate">
                                            {{ $item->deskripsi ?? 'Tidak ada deskripsi' }}
                                        </div>
                                        <span class="custom-tooltip-text">
                                            {{ $item->deskripsi ?? 'Belum ada deskripsi detail untuk alat ini.' }}
                                        </span>
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

                        {{-- Jumlah Total --}}
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <span class="text-sm font-bold text-gray-900">{{ $item->jumlah_total }}</span>
                            <span class="text-xs text-gray-400">Unit</span>
                        </td>

                        {{-- Status Badge dengan Logic Warna & Tooltip --}}
                        <td class="px-6 py-5 whitespace-nowrap text-center">
                            <div class="custom-tooltip-container">
                                @php
                                    $statusClass = match($item->status_ketersediaan) {
                                        'Tersedia' => 'bg-green-100 text-green-800 border-green-200',
                                        'Dipinjam' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'Rusak' => 'bg-red-100 text-red-800 border-red-200',
                                        'Perbaikan' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                    $tooltipText = match($item->status_ketersediaan) {
                                        'Tersedia' => 'Barang siap dipinjam oleh mahasiswa',
                                        'Dipinjam' => 'Barang sedang digunakan',
                                        'Rusak' => 'Barang tidak bisa digunakan',
                                        'Perbaikan' => 'Sedang dalam maintenance',
                                        default => 'Status tidak diketahui'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClass }} cursor-help">
                                    {{ $item->status_ketersediaan }}
                                </span>
                                <span class="custom-tooltip-text">{{ $tooltipText }}</span>
                            </div>
                        </td>

                        {{-- Aksi Buttons --}}
                        <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                            {{-- FIX: Tambahkan 'items-center' agar anak-anaknya sejajar vertikal --}}
                            <div class="flex justify-end items-center space-x-3">
                                
                                {{-- Edit Button --}}
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
                        <td colspan="5" class="px-6 py-16 text-center text-gray-500 bg-gray-50 animate-row">
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