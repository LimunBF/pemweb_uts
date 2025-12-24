@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- LOGIKA PEMISAH DATA (Berdasarkan status di database) --}}
    @php
        // Filter Pinjaman Aktif (Menunggu atau Disetujui)
        $activeLoans = $loans->filter(function($l) {
            return in_array($l->status, ['menunggu_persetujuan', 'disetujui']);
        });

        // Filter Riwayat (Kembali atau Ditolak)
        $historyLoans = $loans->filter(function($l) {
            return in_array($l->status, ['kembali', 'ditolak']);
        });
    @endphp

    {{-- ========================================== --}}
    {{-- BAGIAN 1: PINJAMAN AKTIF (Perlu Perhatian) --}}
    {{-- ========================================== --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <div class="bg-pink-600 p-2 rounded-lg mr-3 shadow-sm text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pinjaman Aktif</h2>
                    <p class="text-sm text-gray-500">Pantau deadline pengembalian barang di sini.</p>
                </div>
            </div>
            
            {{-- Tombol Tambah (Opsional, agar user mudah meminjam lagi) --}}
            <a href="{{ route('student.loan.form') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow text-sm">
                + Pinjam Baru
            </a>
        </div>

        {{-- Flash Message Sukses --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5">
            @forelse($activeLoans as $loan)
                @php
                    // Cek keterlambatan secara real-time
                    $isOverdue = $loan->status == 'disetujui' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($loan->tanggal_kembali));
                @endphp

                <div class="bg-white rounded-xl shadow-md border-l-8 p-6 flex flex-col md:flex-row justify-between items-center hover:shadow-lg transition-shadow duration-200 
                    {{ $isOverdue ? 'border-red-500' : ($loan->status == 'menunggu_persetujuan' ? 'border-yellow-400' : 'border-blue-500') }}">
                    
                    {{-- Kiri: Info Barang --}}
                    <div class="flex items-center w-full md:w-1/3 mb-4 md:mb-0">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-2xl mr-4 border border-gray-100">
                            📦
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $loan->item->nama_alat ?? 'Item Dihapus' }}</h3>
                            <div class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded inline-block mt-1">
                                {{ $loan->item->kode_alat ?? '-' }}
                            </div>
                        </div>
                    </div>

                    {{-- Tengah: Info Tanggal --}}
                    <div class="grid grid-cols-2 gap-8 w-full md:w-1/3 text-center md:text-left mb-4 md:mb-0 border-t md:border-t-0 md:border-l border-b md:border-b-0 md:border-r border-gray-100 py-3 md:py-0 md:px-6">
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider font-bold">Tgl Pinjam</span>
                            <span class="text-sm font-medium text-gray-600">
                                {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] uppercase tracking-wider font-bold {{ $isOverdue ? 'text-red-500' : 'text-blue-500' }}">
                                Deadline
                            </span>
                            <span class="text-lg font-bold {{ $isOverdue ? 'text-red-600' : 'text-gray-800' }}">
                                {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}
                            </span>
                            @if($isOverdue)
                                <span class="block text-[10px] text-red-500 font-bold">
                                    Telat {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($loan->tanggal_kembali)) }} hari!
                                </span>
                            @else
                                <span class="block text-[10px] text-gray-400">
                                    {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Kanan: Status Badge --}}
                    <div class="w-full md:w-1/4 flex justify-end">
                        @if($loan->status == 'disetujui')
                            @if($isOverdue)
                                <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase tracking-wide shadow-sm animate-pulse">
                                    Terlambat
                                </span>
                            @else
                                <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wide shadow-sm">
                                    Sedang Dipinjam
                                </span>
                            @endif
                        @elseif($loan->status == 'menunggu_persetujuan')
                            <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold uppercase tracking-wide shadow-sm">
                                Menunggu Konfirmasi
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Tidak ada barang yang sedang dipinjam.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: RIWAYAT SELESAI (Arsip)        --}}
    {{-- ========================================== --}}
    @if($historyLoans->count() > 0)
    <div class="mt-12 opacity-80 hover:opacity-100 transition-opacity duration-300">
        <div class="flex items-center mb-6">
            <div class="bg-green-100 p-2 rounded-lg mr-3 text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-600">Riwayat Pengembalian</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kembali</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($historyLoans as $loan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-medium text-gray-700">{{ $loan->item->nama_alat ?? 'Item Dihapus' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            @if($loan->status == 'kembali')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    SELESAI
                                </span>
                            @elseif($loan->status == 'ditolak')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                    DITOLAK
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Pagination Links (Wajib ada agar tidak error saat pindah halaman) --}}
    <div class="mt-8">
        {{ $loans->links() }}
    </div>

</div>
@endsection