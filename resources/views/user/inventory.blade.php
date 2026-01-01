@extends('layouts.app')

@section('content')
    <div class="container mx-auto max-w-7xl pb-24">

        {{-- 1. HEADER BANNER (Konsisten dengan Dashboard) --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-8 mb-8 text-white shadow-lg flex items-center justify-between relative overflow-hidden min-h-[160px]">
            {{-- Konten Teks --}}
            <div class="relative z-10">
                <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-2">
                    Katalog Inventaris 📦
                </h1>
                <p class="mt-2 text-pink-100 opacity-90 max-w-xl">
                    Pantau ketersediaan alat, spesifikasi, dan stok gudang secara real-time.
                </p>
            </div>

            {{-- Dekorasi --}}
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>
            
            {{-- Ilustrasi 3D --}}
            <div class="absolute right-8 -bottom-4 z-20 hidden md:block">
                <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/Objects/Card%20File%20Box.png" alt="Inventory Icon" class="w-36 h-auto filter drop-shadow-xl animate-fade-in-up">
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-pink-100 overflow-hidden">
            <table class="min-w-full divide-y divide-pink-200">
                <thead class="bg-lab-pink">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-lab-text uppercase tracking-wider">Nama Alat
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-lab-text uppercase tracking-wider">Kode</th>

                        {{-- Kolom Informasi Stok --}}
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Total
                            Aset
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-yellow-700 uppercase tracking-wider">Sedang
                            Dipinjam</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-green-700 uppercase tracking-wider">Sisa
                            Ready</th>

                        <th class="px-6 py-4 text-center text-xs font-bold text-lab-text uppercase tracking-wider">Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($items as $item)
                        <tr class="hover:bg-pink-50 transition duration-150">

                            {{-- Nama & Deskripsi --}}
                            <td class="px-6 py-4 relative">
                                <div class="relative group cursor-pointer">

                                    {{-- Teks Nama & Deskripsi --}}
                                    <div
                                        class="text-sm font-bold text-gray-900 group-hover:text-lab-pink-btn transition-colors">
                                        {{ $item->nama_alat }}
                                    </div>
                                    <div class="text-xs text-gray-500 truncate w-48">
                                        {{ $item->deskripsi ?? 'Tidak ada deskripsi' }}
                                    </div>

                                    {{-- LOGIKA SMART TOOLTIP --}}
                                    <div
                                        class="absolute z-50 w-72 hidden group-hover:block animate-fade-in-up 
                        {{ $loop->first ? 'top-full mt-2' : 'bottom-full mb-2' }} left-0">

                                        <div class="bg-white rounded-lg shadow-2xl border border-lab-pink p-4 relative">

                                            {{-- PANAH TOOLTIP --}}
                                            <div
                                                class="absolute w-4 h-4 bg-white transform rotate-45 
                                {{ $loop->first ? '-top-2 left-6 border-t border-l border-lab-pink' : '-bottom-2 left-6 border-b border-r border-lab-pink' }}">
                                            </div>

                                            {{-- Isi Konten --}}
                                            <h4 class="text-sm font-bold text-lab-text mb-2 border-b border-pink-100 pb-1">
                                                {{ $item->nama_alat }}
                                            </h4>
                                            <p class="text-xs text-gray-600 leading-relaxed text-justify">
                                                {{ $item->deskripsi ?? 'Tidak ada deskripsi lengkap untuk alat ini.' }}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </td>

                            {{-- Kode Alat --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $item->kode_alat ?? '-' }}
                            </td>

                            {{-- Total Aset --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-600">
                                {{ $item->jumlah_total }}
                            </td>

                            {{-- Sedang Dipinjam --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($item->stok_dipinjam > 0)
                                    <span class="px-2 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded-full">
                                        {{ $item->stok_dipinjam }} Unit
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>

                            {{-- Sisa Ready --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="px-3 py-1 text-sm font-extrabold {{ $item->stok_ready > 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} rounded-lg">
                                    {{ $item->stok_ready }} Unit
                                </span>
                            </td>

                            {{-- Status Ketersediaan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if ($item->stok_ready > 0)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <span class="w-2 h-2 mr-1.5 bg-green-500 rounded-full"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <span class="w-2 h-2 mr-1.5 bg-red-500 rounded-full"></span>
                                        Stok Habis
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">
                                Belum ada data inventaris.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
