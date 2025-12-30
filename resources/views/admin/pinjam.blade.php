@extends('layouts.app')

@section('content')
    {{-- Script Config Tailwind (Inline) --}}
    <script>
        if (typeof tailwind !== 'undefined') {
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'lab-pink-btn': '#db2777', // Pink-600
                            'lab-text': '#1f2937',     // Gray-800
                        }
                    }
                }
            }
        }
    </script>

    <div class="container mx-auto px-4 py-8 max-w-7xl">
        {{-- FLASH MESSAGE --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center" role="alert">
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-700 font-bold text-xl">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Terjadi Kesalahan!</p>
                <ul class="list-disc ml-5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HEADER (Tombol Tambah Peminjam Diaktifkan) --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-8 mb-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10 pointer-events-none"></div>
            <div class="flex flex-col md:flex-row justify-between items-center relative z-10 gap-4">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold">Data Peminjaman</h2>
                    <p class="mt-2 text-pink-100 opacity-90">
                        Kelola permohonan masuk dan pantau status inventaris.
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    {{-- Pastikan nama route ini sesuai dengan routes/web.php (misal: admin.peminjaman.create) --}}
                    <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-5 py-2.5 bg-white text-lab-pink-btn border border-transparent rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-pink-50 transition shadow-lg transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Peminjam
                    </a>
                </div>
            </div>
        </div>

        {{-- BAGIAN 1: PERMINTAAN MASUK (PENDING) --}}
        @if(isset($pendingLoans) && $pendingLoans->count() > 0)
            <div class="mb-10 animate-fade-in-down">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-yellow-100 p-2 rounded-lg text-yellow-600 animate-pulse">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">
                        Permintaan Baru 
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full ml-2 shadow-sm">{{ $pendingLoans->count() }} Surat</span>
                    </h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg border-2 border-yellow-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-yellow-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Peminjam</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Daftar Barang</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase">Durasi</th>
                                <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pendingLoans as $kode => $items)
                                @php
                                    $firstItem = $items->first();
                                @endphp
                                <tr class="hover:bg-yellow-50/50 transition">
                                    <td class="px-6 py-4 align-top">
                                        <div class="font-bold text-gray-800">{{ $firstItem->user->name ?? 'User dihapus' }}</div>
                                        <div class="text-xs text-gray-500 mb-1">{{ $firstItem->user->identity_number ?? '-' }}</div>
                                        <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded font-mono">{{ $kode }}</span>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="text-xs text-gray-500 italic mb-2">"{{ $firstItem->alasan }}"</div>
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($items as $loan)
                                                <li class="text-sm font-medium text-gray-700">
                                                    {{ $loan->item->nama_alat }} 
                                                    <span class="text-xs text-gray-500 font-bold bg-white border px-1 rounded ml-1">x{{ $loan->amount ?? 1 }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 text-center align-top text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($firstItem->tanggal_pinjam)->format('d M') }} 
                                        <span class="text-gray-400 mx-1">-</span>
                                        {{ \Carbon\Carbon::parse($firstItem->tanggal_kembali)->format('d M') }}
                                    </td>
                                    <td class="px-6 py-4 text-center align-top">
                                        <div class="flex justify-center gap-3">
                                            <form action="{{ route('peminjaman.update', $firstItem->id) }}" method="POST" onsubmit="return confirm('Setujui permintaan ini?');">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="disetujui">
                                                <button type="submit" class="flex items-center gap-1 bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Setujui
                                                </button>
                                                
                                            </form>
                                            <form action="{{ route('peminjaman.update', $firstItem->id) }}" method="POST" onsubmit="return confirm('Tolak permintaan ini?')">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="ditolak">
                                                <button type="submit" class="flex items-center gap-1 bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- BAGIAN 2: DAFTAR RIWAYAT & FILTER --}}
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter & Cetak Data
            </h3>
            
            <form action="{{ route('peminjaman') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    
                    {{-- 1. Filter Kategori User --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kategori User</label>
                        <select name="role" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                            <option value="">Semua User</option>
                            <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                    </div>

                    {{-- 2. Filter Tanggal Mulai --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                    </div>

                    {{-- 3. Filter Tanggal Akhir --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                    </div>

                    {{-- 4. Filter Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                        <select name="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                            <option value="">Semua Status</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui (Sedang Dipinjam)</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    
                    {{-- TOMBOL FILTER & CETAK --}}
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 p-2.5 bg-lab-pink-btn text-white rounded-lg hover:bg-pink-700 transition shadow-sm font-bold text-sm">
                            Filter
                        </button>
                        
                        <a href="{{ route('peminjaman.cetak', request()->all()) }}" target="_blank" class="flex-1 p-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition shadow-sm font-bold text-sm text-center flex items-center justify-center gap-2" title="Cetak Laporan PDF">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABEL DATA RIWAYAT --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Peminjam</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Barang</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjaman as $pinjam)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $pinjam->user->name ?? 'User Terhapus' }}</div>
                            <div class="text-xs text-gray-500">{{ $pinjam->user->identity_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $pinjam->item->nama_alat ?? 'Barang Terhapus' }}</div>
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m') }} - {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $badge = match($pinjam->status) {
                                    'disetujui' => 'bg-green-100 text-green-700',
                                    'dikembalikan' => 'bg-blue-100 text-blue-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    'terlambat' => 'bg-red-600 text-white animate-pulse',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp
                            <span class="px-2 py-1 text-xs font-bold rounded-full {{ $badge }}">
                                {{ ucfirst($pinjam->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            @if($pinjam->status == 'disetujui' || $pinjam->status == 'terlambat')
                                <form action="{{ route('peminjaman.update', $pinjam->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="dikembalikan">
                                    <button type="submit" class="text-xs bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700 transition font-bold">
                                        Tandai Kembali
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Tidak ada data peminjaman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $peminjaman->links() }}
        </div>

    </div>
@endsection