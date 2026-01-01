@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- LOGIC PHP: Cek Keterlambatan Global --}}
    @php
        $hasLateItems = isset($groupedLoans) && $groupedLoans->flatten()->contains('status', 'terlambat');
    @endphp

    {{-- 1. WARNING ALERT (GLOBAL) --}}
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

    {{-- HEADER BANNER (REVISI) --}}
    <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-8 mb-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between relative overflow-hidden min-h-[150px] gap-6">
        
        {{-- 1. Konten Teks --}}
        <div class="relative z-10 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold flex items-center justify-center md:justify-start gap-2">
                Riwayat Peminjaman 📋
            </h1>
            <p class="mt-2 text-pink-100 opacity-90 max-w-xl">
                Pantau status pengajuan, cetak surat bukti, dan cek tenggat waktu pengembalian alat.
            </p>
        </div>

        {{-- 2. Tombol Ajukan Baru (Tetap Ada & Dipercantik) --}}
        <div class="relative z-10">
            <a href="{{ route('student.loan.form') }}" class="group bg-white text-lab-pink-btn hover:bg-pink-50 font-bold py-3 px-6 rounded-xl shadow-lg transition-all duration-300 flex items-center transform hover:-translate-y-1 border border-pink-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform duration-500 ease-in-out group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajukan Baru
            </a>
        </div>

        {{-- 3. Dekorasi Background --}}
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10 pointer-events-none"></div>
        <div class="absolute -bottom-6 right-20 w-32 h-32 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 pointer-events-none animate-pulse"></div>
    </div>

    {{-- ========================================== --}}
    {{-- FILTER SECTION (REALTIME & OTOMATIS) --}}
    {{-- ========================================== --}}
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-8 relative">
        
        {{-- Loading Overlay (Muncul saat filter berubah) --}}
        <div id="filter-loading" class="hidden absolute inset-0 bg-white/70 backdrop-blur-sm z-10 rounded-xl flex items-center justify-center">
            <div class="flex items-center gap-2 text-lab-pink-btn font-bold animate-pulse">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Memuat Data...
            </div>
        </div>

        <form action="{{ route('student.loans') }}" method="GET" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                
                {{-- Filter Status (Langsung Submit) --}}
                <div class="relative">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Status Peminjaman</label>
                    <select name="status" id="statusFilter" class="w-full text-sm border-gray-200 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn bg-gray-50 transition cursor-pointer hover:bg-white" onchange="submitFilter()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui / Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Selesai (Dikembalikan)</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>

                {{-- Filter Tanggal Mulai --}}
                <div class="relative">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full text-sm border-gray-200 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn bg-gray-50 cursor-pointer">
                </div>

                {{-- Filter Tanggal Akhir --}}
                <div class="relative">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full text-sm border-gray-200 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn bg-gray-50 cursor-pointer">
                </div>

            </div>

            {{-- Chip Filter Aktif & Tombol Reset (Muncul otomatis jika ada filter) --}}
            @if(request()->hasAny(['status', 'start_date', 'end_date']))
                <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">
                    <div class="text-xs text-gray-500 italic">
                        Menampilkan hasil filter...
                    </div>
                    <a href="{{ route('student.loans') }}" class="text-xs font-bold text-red-500 hover:text-red-700 flex items-center gap-1 transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Hapus Filter
                    </a>
                </div>
            @endif
        </form>
    </div>

    {{-- Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- LIST CARD --}}
    @if(isset($groupedLoans) && $groupedLoans->count() > 0)
        <div class="space-y-6 animate-fade-in-up">
            @foreach($groupedLoans as $kode => $items)
                @php
                    $firstItem = $items->first();
                    $status = $firstItem->status;
                    
                    // Warna Badge
                    $badgeColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'disetujui' => 'bg-green-100 text-green-800 border-green-200',
                        'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                        'dikembalikan' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'terlambat' => 'bg-red-100 text-red-800 font-bold border-red-200 animate-pulse',
                    ];
                    $badgeColor = $badgeColors[$status] ?? 'bg-gray-100 text-gray-800';

                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'disetujui' => 'Disetujui / Dipinjam',
                        'ditolak' => 'Ditolak',
                        'dikembalikan' => 'Selesai',
                        'terlambat' => 'Terlambat',
                    ];
                    $statusLabel = $statusLabels[$status] ?? ucfirst($status);

                    // Logic Hitung Hari
                    $lateText = '';
                    if ($status == 'terlambat') {
                        $deadline = \Carbon\Carbon::parse($firstItem->tanggal_kembali);
                        $now = \Carbon\Carbon::now();
                        $diff = $deadline->diff($now);
                        $parts = [];
                        if ($diff->d > 0) $parts[] = $diff->d . ' Hari';
                        if ($diff->h > 0) $parts[] = $diff->h . ' Jam';
                        $lateText = 'Telat ' . (implode(' ', $parts) ?: 'Baru saja'); 
                    }
                @endphp

                <div class="bg-white rounded-xl shadow-md border {{ $status == 'terlambat' ? 'border-red-300' : 'border-pink-100' }} overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    
                    {{-- Header Kartu --}}
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <div class="flex items-center flex-wrap gap-3">
                                <span class="text-xs font-mono font-bold text-gray-400 uppercase tracking-wider">
                                    #{{ $kode }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                    {{ $statusLabel }}
                                </span>

                                @if($status == 'terlambat')
                                    <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-red-600 text-white border border-red-700 shadow-sm flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $lateText }}
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Diajukan: {{ \Carbon\Carbon::parse($firstItem->created_at)->translatedFormat('d F Y, H:i') }}
                            </div>
                        </div>
                        
                        {{-- Tombol Cetak Surat --}}
                        @if(in_array($status, ['pending', 'disetujui', 'terlambat'])) 
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
                            <div class="text-sm text-gray-600 border-l-4 {{ $status == 'terlambat' ? 'border-red-500' : 'border-lab-pink' }} pl-4 h-fit">
                                <p class="mb-1"><span class="font-bold">Mulai Pinjam:</span> <br> {{ \Carbon\Carbon::parse($firstItem->tanggal_pinjam)->translatedFormat('d F Y') }}</p>
                                
                                <p class="mb-2">
                                    <span class="font-bold">Rencana Kembali:</span> <br> 
                                    <span class="{{ $status == 'terlambat' ? 'text-red-600 font-bold bg-red-50 px-1 rounded' : '' }}">
                                        {{ \Carbon\Carbon::parse($firstItem->tanggal_kembali)->translatedFormat('d F Y') }}
                                    </span>
                                </p>
                                
                                <div class="mt-3">
                                    <span class="text-xs font-bold text-gray-400 uppercase">Keperluan:</span>
                                    <p class="italic text-gray-700">"{{ $firstItem->alasan }}"</p>
                                </div>
                            </div>

                            {{-- Daftar Barang --}}
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-bold text-gray-700 mb-3 border-b pb-2 flex justify-between items-center">
                                    Daftar Barang
                                    @if($status == 'terlambat')
                                         <span class="text-[10px] text-red-500 font-bold uppercase animate-pulse">! Pengembalian Tertunda</span>
                                    @endif
                                </h4>
                                <ul class="space-y-2">
                                    @foreach($items as $loan)
                                        <li class="flex flex-col sm:flex-row sm:items-center justify-between bg-gray-50 px-4 py-3 rounded-lg border {{ $status == 'terlambat' ? 'border-red-200 bg-red-50' : 'border-gray-100' }}">
                                            <div class="flex items-center mb-2 sm:mb-0">
                                                <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center font-bold border border-pink-100 mr-3 shadow-sm text-sm {{ $status == 'terlambat' ? 'text-red-600 border-red-200' : 'text-lab-pink-btn' }}">
                                                    {{ substr($loan->item->nama_alat, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-gray-800 block">{{ $loan->item->nama_alat }}</span>
                                                    <span class="text-xs text-gray-400 block font-mono">{{ $loan->item->kode_alat }}</span>
                                                </div>
                                            </div>
                                            <span class="text-sm font-bold bg-white px-3 py-1 rounded border shadow-sm {{ $status == 'terlambat' ? 'text-red-600 border-red-200' : 'text-gray-600 border-gray-200' }}">
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
        <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100 animate-fade-in-up overflow-hidden relative">
            
            {{-- Dekorasi Background Blob --}}
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-pink-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

            <div class="relative z-10 flex flex-col items-center">
                <div class="w-56 h-56 mb-2">
                    <svg viewBox="0 0 400 300" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <ellipse cx="200" cy="260" rx="120" ry="10" fill="#F3F4F6"/>
                        
                        <path d="M130 180 L200 210 L270 180 L200 150 L130 180 Z" fill="#E5E7EB"/>
                        <path d="M130 180 V250 L200 280 V210 L130 180 Z" fill="#D1D5DB"/>
                        <path d="M270 180 V250 L200 280 V210 L270 180 Z" fill="#9CA3AF"/>
                        <path d="M130 180 L80 140 L150 110 L200 150 L130 180 Z" fill="#D1D5DB" stroke="white" stroke-width="2"/>
                        <path d="M270 180 L320 140 L250 110 L200 150 L270 180 Z" fill="#D1D5DB" stroke="white" stroke-width="2"/>

                        <circle cx="150" cy="100" r="3" fill="#DB2777" class="animate-bounce" style="animation-duration: 2s"/>
                        <circle cx="250" cy="80" r="5" fill="#FF91A4" class="animate-bounce" style="animation-duration: 3s"/>
                        <rect x="180" y="60" width="40" height="50" rx="4" fill="white" stroke="#DB2777" stroke-width="2" transform="rotate(15)" class="animate-pulse"/>
                        <path d="M190 75 H210" stroke="#DB2777" stroke-width="2"/>
                        <path d="M190 85 H210" stroke="#DB2777" stroke-width="2"/>
                    </svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-800">
                    {{ request()->hasAny(['status', 'start_date', 'end_date']) ? 'Tidak Ada Data Ditemukan' : 'Belum Ada Pinjaman' }}
                </h3>
                
                <p class="mt-2 text-gray-500 max-w-md mx-auto leading-relaxed">
                    {{ request()->hasAny(['status', 'start_date', 'end_date']) 
                        ? 'Filter yang Anda terapkan tidak cocok dengan data manapun. Coba reset filter untuk melihat semua data.' 
                        : 'Saat ini Anda tidak memiliki barang yang sedang dipinjam atau riwayat peminjaman sebelumnya.' }}
                </p>

                <div class="mt-8">
                    @if(request()->hasAny(['status', 'start_date', 'end_date']))
                        <a href="{{ route('student.loans') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition transform hover:-translate-y-1">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Reset Filter
                        </a>
                    @else
                        <a href="{{ route('student.loan.form') }}" class="inline-flex items-center px-8 py-3 border border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-lab-pink-btn hover:bg-pink-700 transition transform hover:-translate-y-1 hover:shadow-pink-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Pengajuan Baru
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

{{-- SCRIPT: LOGIKA REALTIME & TANGGAL --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const loading = document.getElementById('filter-loading');

        // Fungsi Submit
        window.submitFilter = function() {
            loading.classList.remove('hidden'); // Tampilkan loading
            form.submit();
        }

        // 1. Logic Status (Langsung submit saat ganti)
        document.getElementById('statusFilter').addEventListener('change', submitFilter);

        // 2. Logic Tanggal
        startDate.addEventListener('change', function() {
            endDate.min = this.value; // Tanggal akhir min = tanggal mulai
            
            // Jika tanggal akhir invalid, reset
            if (endDate.value && endDate.value < this.value) {
                endDate.value = '';
            }

            // AUTO SUBMIT: Hanya jika KEDUA tanggal terisi
            if (this.value && endDate.value) {
                submitFilter();
            }
        });

        endDate.addEventListener('change', function() {
            // AUTO SUBMIT: Hanya jika KEDUA tanggal terisi
            if (startDate.value && this.value) {
                submitFilter();
            }
        });
    });
</script>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
</style>
@endsection