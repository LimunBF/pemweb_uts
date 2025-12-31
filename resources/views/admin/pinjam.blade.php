@extends('layouts.app')

@section('content')

<div class="container mx-auto"> 
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center animate-fade-in-up" role="alert">
            <div>
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold text-xl">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Terjadi Kesalahan!</p>
            <ul class="list-disc ml-5 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-8 mb-8 text-white shadow-lg relative overflow-hidden flex items-center justify-between">
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold">Manajemen Peminjaman</h2>
            <p class="mt-2 text-pink-100 opacity-90">
                Kelola persetujuan dan pantau status barang lab.
            </p>
        </div>
        
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10 pointer-events-none"></div>
        <div class="relative z-20 hidden md:block">
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-5 py-3 bg-white text-lab-pink-btn border border-transparent rounded-xl font-bold text-sm uppercase tracking-widest hover:bg-pink-50 transition shadow-lg transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Baru
            </a>
        </div>
    </div>

    <div class="md:hidden mb-6">
        <a href="{{ route('peminjaman.create') }}" class="block w-full text-center px-5 py-3 bg-lab-pink-btn text-white rounded-xl font-bold text-sm shadow-lg">
            + Input Peminjaman Baru
        </a>
    </div>
    @if(isset($pendingLoans) && $pendingLoans->count() > 0)
        <div class="mb-10 animate-fade-in-up">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-yellow-100 p-2 rounded-lg text-yellow-600 animate-pulse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">
                    Permintaan Masuk 
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full ml-2 shadow-sm align-middle">{{ $pendingLoans->count() }}</span>
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pendingLoans as $kode => $items)
                    @php $first = $items->first(); @endphp
                    
                    <div class="bg-white rounded-2xl shadow-md border border-yellow-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="bg-yellow-50 px-5 py-3 border-b border-yellow-100 flex justify-between items-center">
                            <span class="text-xs font-mono font-bold text-yellow-700 bg-white px-2 py-1 rounded border border-yellow-200">
                                #{{ \Illuminate\Support\Str::limit($kode, 10) }}
                            </span>
                            <span class="text-[10px] font-bold text-gray-400">
                                {{ $first->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex items-center mb-4">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 text-white flex items-center justify-center font-bold mr-3 text-sm">
                                    {{ substr($first->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800 line-clamp-1">{{ $first->user->name }}</h4>
                                    <p class="text-xs text-gray-500 font-mono">{{ $first->user->identity_number }}</p>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded-lg mb-4 border border-gray-100 grid grid-cols-2 gap-2">
                                <div>
                                    <span class="block text-gray-400 uppercase text-[10px] font-bold">Mulai</span>
                                    <span class="font-bold">{{ \Carbon\Carbon::parse($first->tanggal_pinjam)->format('d M') }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-gray-400 uppercase text-[10px] font-bold">Kembali</span>
                                    <span class="font-bold text-lab-pink-btn">{{ \Carbon\Carbon::parse($first->tanggal_kembali)->format('d M') }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Item diminta:</p>
                                <ul class="space-y-1">
                                    @foreach($items as $loan)
                                        <li class="flex justify-between items-center text-sm border-b border-dashed border-gray-100 last:border-0 pb-1">
                                            <span class="text-gray-700 truncate w-3/4">{{ $loan->item->nama_alat }}</span>
                                            <span class="font-bold text-gray-800 bg-gray-100 px-1.5 rounded text-xs">x{{ $loan->amount }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if($first->alasan)
                                <div class="text-xs italic text-gray-500 mb-3 bg-yellow-50/50 p-2 rounded">"{{ $first->alasan }}"</div>
                            @endif
                            @if($first->file_surat)
                                <a href="{{ asset('storage/'.$first->file_surat) }}" target="_blank" class="block w-full text-center text-xs font-bold text-blue-600 hover:text-blue-800 bg-blue-50 py-2 rounded-lg border border-blue-100 transition hover:shadow-sm">
                                    📄 Lihat Surat
                                </a>
                            @endif
                        </div>

                        <div class="px-5 py-4 bg-gray-50 border-t border-gray-100 flex gap-2">
                            <form action="{{ route('peminjaman.update', $first->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="button" 
                                        onclick="confirmSubmit(this, 'Tolak Permintaan?', 'Apakah Anda yakin ingin menolak peminjaman ini?', 'Ya, Tolak', '#EF4444')" 
                                        class="w-full py-2 rounded-lg border border-red-200 text-red-600 text-sm font-bold hover:bg-red-50 transition">
                                    Tolak
                                </button>
                            </form>

                            <form action="{{ route('peminjaman.update', $first->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="disetujui">
                                <button type="button" 
                                        onclick="confirmSubmit(this, 'Setujui Permintaan?', 'Barang akan status dipinjam.', 'Ya, Setujui', '#10B981')" 
                                        class="w-full py-2 rounded-lg bg-green-500 text-white text-sm font-bold shadow hover:bg-green-600 transition">
                                    Setujui
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl p-8 text-center border border-gray-200 shadow-sm mb-8">
                <div class="bg-gray-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-gray-500 text-sm font-medium">Tidak ada permintaan baru saat ini.</p>
            </div>
        @endif
    
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 relative">
        <div id="filter-loading" class="hidden absolute inset-0 bg-white/70 backdrop-blur-sm z-20 rounded-xl flex items-center justify-center">
            <div class="flex items-center gap-2 text-lab-pink-btn font-bold animate-pulse">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Memuat Data...
            </div>
        </div>

        <form action="{{ route('peminjaman') }}" method="GET" id="filterForm">
            <input type="hidden" name="period" id="periodInput" value="{{ request('period', 'all') }}">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Riwayat & Filter
                </h3>

                {{-- QUICK DATE FILTERS --}}
                <div class="flex gap-2 overflow-x-auto pb-1 md:pb-0">
                    <button type="button" onclick="setQuickDate('all')" 
                        class="px-4 py-1.5 text-xs font-bold rounded-full border transition duration-200 
                        {{ request('period') == 'all' || !request('period') ? 'bg-lab-pink-btn text-white border-lab-pink-btn shadow-md' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                        Semua
                    </button>
                    <button type="button" onclick="setQuickDate('1_month')" 
                        class="px-4 py-1.5 text-xs font-bold rounded-full border transition duration-200 
                        {{ request('period') == '1_month' ? 'bg-lab-pink-btn text-white border-lab-pink-btn shadow-md' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                        1 Bulan
                    </button>
                    <button type="button" onclick="setQuickDate('6_months')" 
                        class="px-4 py-1.5 text-xs font-bold rounded-full border transition duration-200 
                        {{ request('period') == '6_months' ? 'bg-lab-pink-btn text-white border-lab-pink-btn shadow-md' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                        6 Bulan
                    </button>
                    <button type="button" onclick="setQuickDate('1_year')" 
                        class="px-4 py-1.5 text-xs font-bold rounded-full border transition duration-200 
                        {{ request('period') == '1_year' ? 'bg-lab-pink-btn text-white border-lab-pink-btn shadow-md' : 'bg-white text-gray-500 border-gray-200 hover:bg-gray-50' }}">
                        1 Tahun
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                
                {{-- Filter Role --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">User</label>
                    <select name="role" id="roleFilter" class="w-full text-sm border-gray-200 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn cursor-pointer hover:bg-gray-50 transition" onchange="submitFilter()">
                        <option value="">Semua</option>
                        <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Dari</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="w-full text-sm border-gray-200 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn cursor-pointer hover:bg-gray-50">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Sampai</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="w-full text-sm border-gray-200 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn cursor-pointer hover:bg-gray-50">
                </div>

                {{-- Filter Status --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Status</label>
                    <select name="status" id="statusFilter" class="w-full text-sm border-gray-200 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn cursor-pointer hover:bg-gray-50 transition" onchange="submitFilter()">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>📂 Semua Riwayat</option>
                        <option disabled>──────────</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>🟢 Sedang Dipinjam</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>⚠️ Terlambat</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>🔵 Dikembalikan</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>🔴 Ditolak</option>
                    </select>
                </div>
                
                {{-- Tombol Cetak --}}
                <div class="flex items-end">
                    <a href="{{ route('peminjaman.cetak', request()->all()) }}" target="_blank" class="w-full p-2.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition text-sm font-bold text-center flex justify-center items-center gap-2 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Laporan
                    </a>
                </div>
            </div>
            
            {{-- Reset Button --}}
            @if(request()->hasAny(['role', 'start_date', 'end_date', 'status']) && request('period') != 'all')
                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                    <a href="{{ route('peminjaman') }}" class="text-xs font-bold text-red-500 hover:text-red-700 flex items-center gap-1 transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Hapus Filter
                    </a>
                </div>
            @endif
        </form>

        {{-- TABEL RIWAYAT --}}
        <div class="mt-6 overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Daftar Barang</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm bg-white">
                    @forelse($peminjaman as $kode => $items)
                        @php 
                            $first = $items->first(); 
                            $status = $first->status;
                            
                            $badgeColor = match($status) {
                                'disetujui' => 'bg-green-100 text-green-700 border border-green-200',
                                'dikembalikan' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                'ditolak' => 'bg-red-100 text-red-700 border border-red-200',
                                'terlambat' => 'bg-red-600 text-white animate-pulse',
                                default => 'bg-gray-100 text-gray-600'
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 align-top">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeColor }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-gray-800">{{ $first->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $first->user->identity_number }}</div>
                                <div class="text-[10px] text-gray-400 mt-1 font-mono bg-gray-100 inline-block px-1 rounded">#{{ \Illuminate\Support\Str::limit($kode, 8) }}</div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <ul class="space-y-1">
                                    @foreach($items as $loan)
                                        <li class="flex items-center gap-2 text-gray-700 text-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                            <span>{{ $loan->item->nama_alat }}</span>
                                            <span class="text-xs font-bold text-gray-500 bg-gray-100 px-1.5 py-0.5 rounded">x{{ $loan->amount }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col text-xs space-y-1">
                                    <span class="text-gray-500">Pinjam: <strong class="text-gray-700">{{ \Carbon\Carbon::parse($first->tanggal_pinjam)->format('d/m/y') }}</strong></span>
                                    <span class="text-gray-500">Kembali: <strong class="text-lab-pink-btn">{{ \Carbon\Carbon::parse($first->tanggal_kembali)->format('d/m/y') }}</strong></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top text-center">
                                @if($status == 'disetujui' || $status == 'terlambat')
                                    <form action="{{ route('peminjaman.update', $first->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="dikembalikan">
                                        <button type="button" 
                                                onclick="confirmSubmit(this, 'Konfirmasi Pengembalian?', 'Pastikan semua barang telah dicek kondisinya.', 'Ya, Barang Kembali', '#1F2937')"
                                                class="bg-gray-800 hover:bg-gray-900 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow transition flex items-center justify-center gap-1 mx-auto">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs italic">- Selesai -</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    <p>Tidak ada data riwayat peminjaman.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $peminjaman->links() }}
        </div>
    </div>
</div>

{{-- SCRIPT: FILTER REALTIME & QUICK DATE --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('filterForm');
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        const periodInput = document.getElementById('periodInput'); // Input Hidden
        const loading = document.getElementById('filter-loading');

        window.submitFilter = function() {
            loading.classList.remove('hidden');
            form.submit();
        }

        // FITUR BARU: Quick Date Setter
        window.setQuickDate = function(type) {
            const today = new Date();
            const formatDate = (date) => {
                const y = date.getFullYear();
                const m = String(date.getMonth() + 1).padStart(2, '0');
                const d = String(date.getDate()).padStart(2, '0');
                return `${y}-${m}-${d}`;
            };

            const endStr = formatDate(today);
            let startStr = '';

            if (type === '1_month') {
                const d = new Date();
                d.setMonth(d.getMonth() - 1);
                startStr = formatDate(d);
            } else if (type === '6_months') {
                const d = new Date();
                d.setMonth(d.getMonth() - 6);
                startStr = formatDate(d);
            } else if (type === '1_year') {
                const d = new Date();
                d.setFullYear(d.getFullYear() - 1);
                startStr = formatDate(d);
            } else if (type === 'all') {
                startStr = ''; 
            }
            startDate.value = startStr;
            endDate.value = (type === 'all') ? '' : endStr;
            periodInput.value = type;

            submitFilter();
        }
        startDate.addEventListener('change', function() {
            periodInput.value = 'custom';
            endDate.min = this.value;
            if (this.value && endDate.value) submitFilter();
        });

        endDate.addEventListener('change', function() {
            periodInput.value = 'custom';
            if (startDate.value && this.value) submitFilter();
        });
    });
</script>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
</style>
@endsection