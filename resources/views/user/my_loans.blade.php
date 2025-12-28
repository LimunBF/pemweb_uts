@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- LOGIC PHP: Cek Keterlambatan --}}
    @php
        // Cek apakah ada item yang statusnya 'terlambat'
        // Menggunakan isset untuk mencegah error jika variabel belum ada
        $hasLateItems = isset($groupedLoans) && $groupedLoans->flatten()->contains('status', 'terlambat');
    @endphp

    {{-- 1. WARNING ALERT --}}
    @if($hasLateItems)
        <div class="mb-6 bg-red-600 rounded-xl shadow-lg shadow-red-200 p-5 flex flex-col md:flex-row items-center justify-between gap-4 text-white animate-pulse border border-red-700">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">PERINGATAN: Pengembalian Terlambat!</h3>
                    <p class="text-red-100 text-sm">Ada barang yang belum dikembalikan melewati batas waktu. Mohon segera diproses.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-lab-text">Pinjaman Saya</h2>
            <p class="text-gray-500 text-sm mt-1">Riwayat dan status pengajuan alat laboratorium.</p>
        </div>
        
        <a href="{{ route('student.loan.form') }}" class="bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition transform hover:-translate-y-1 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Ajukan Baru
        </a>
    </div>

    {{-- Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Cek apakah variabel groupedLoans ada dan tidak kosong --}}
    @if(isset($groupedLoans) && $groupedLoans->count() > 0)
        <div class="space-y-6">
            @foreach($groupedLoans as $kode => $items)
                @php
                    $firstItem = $items->first();
                    $status = $firstItem->status;
                    
                    // Definisikan warna badge (Gunakan Array biasa agar aman di PHP lama)
                    $badgeColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'disetujui' => 'bg-green-100 text-green-800 border-green-200',
                        'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                        'dikembalikan' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'terlambat' => 'bg-red-100 text-red-800 font-bold border-red-200 animate-pulse',
                    ];
                    $badgeColor = $badgeColors[$status] ?? 'bg-gray-100 text-gray-800';

                    // Definisikan Label Status
                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'disetujui' => 'Disetujui / Dipinjam',
                        'ditolak' => 'Ditolak',
                        'dikembalikan' => 'Selesai',
                        'terlambat' => 'Terlambat',
                    ];
                    $statusLabel = $statusLabels[$status] ?? ucfirst($status);
                @endphp

                <div class="bg-white rounded-xl shadow-md border border-pink-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    
                    {{-- Header Kartu --}}
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-mono font-bold text-gray-400 uppercase tracking-wider">
                                    #{{ $kode }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Diajukan: {{ \Carbon\Carbon::parse($firstItem->created_at)->translatedFormat('d F Y, H:i') }}
                            </div>
                        </div>

                        {{-- Tombol Cetak Surat --}}
                        @if(in_array($status, ['pending', 'disetujui']))
                            <a href="{{ route('student.loan.print', $firstItem->id) }}" target="_blank" 
                               class="flex items-center text-sm font-medium text-lab-pink-btn hover:text-pink-900 bg-pink-50 hover:bg-pink-100 px-3 py-2 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Cetak Surat
                            </a>
                        @endif
                    </div>

                    {{-- Body Kartu --}}
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            
                            {{-- Informasi Tanggal --}}
                            <div class="text-sm text-gray-600 border-l-4 border-lab-pink pl-4 h-fit">
                                <p class="mb-1"><span class="font-bold">Mulai Pinjam:</span> <br> {{ \Carbon\Carbon::parse($firstItem->tanggal_pinjam)->translatedFormat('d F Y') }}</p>
                                <p class="mb-2"><span class="font-bold">Rencana Kembali:</span> <br> {{ \Carbon\Carbon::parse($firstItem->tanggal_kembali)->translatedFormat('d F Y') }}</p>
                                
                                <div class="mt-3">
                                    <span class="text-xs font-bold text-gray-400 uppercase">Keperluan:</span>
                                    <p class="italic text-gray-700">"{{ $firstItem->alasan }}"</p>
                                </div>
                            </div>

                            {{-- Daftar Barang --}}
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2">Daftar Barang</h4>
                                <ul class="space-y-2">
                                    @foreach($items as $loan)
                                        <li class="flex items-center justify-between bg-gray-50 px-4 py-3 rounded-lg border border-gray-100">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-lab-pink-btn font-bold border border-pink-100 mr-3 shadow-sm text-sm">
                                                    {{ substr($loan->item->nama_alat, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-gray-800 block">{{ $loan->item->nama_alat }}</span>
                                                    <span class="text-xs text-gray-400 block font-mono">{{ $loan->item->kode_alat }}</span>
                                                </div>
                                            </div>
                                            <span class="text-sm font-bold text-gray-600 bg-white px-3 py-1 rounded border border-gray-200">
                                                {{ $loan->amount }} Unit
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            @if(isset($loans))
                {{ $loans->links() }}
            @endif
        </div>

    @else
        {{-- TAMPILAN KOSONG (JIKA BELUM ADA DATA) --}}
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada riwayat</h3>
            <p class="mt-1 text-sm text-gray-500">Anda belum pernah mengajukan peminjaman alat.</p>
            <div class="mt-6">
                <a href="{{ route('student.loan.form') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-lab-pink-btn hover:bg-pink-700">
                    Buat Pengajuan Baru
                </a>
            </div>
        </div>
    @endif
</div>
@endsection