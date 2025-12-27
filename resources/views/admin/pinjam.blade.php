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

        {{-- HEADER --}}
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
                    {{-- Pastikan route 'peminjaman.create' ada di web.php jika ingin menggunakan tombol ini, jika tidak, arahkan ke # atau hapus --}}
                    {{-- <a href="{{ route('peminjaman.create') }}" ... --}}
                    <button class="inline-flex items-center px-5 py-2.5 bg-white border border-transparent rounded-xl font-bold text-xs text-lab-pink-btn uppercase tracking-widest hover:bg-pink-50 transition shadow-lg opacity-50 cursor-not-allowed" title="Fitur Tambah Manual (Coming Soon)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Peminjam
                    </button>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter Data Peminjaman
            </h3>
            
            <form action="{{ route('peminjaman') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                        <select name="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                            <option value="">-- Semua Status --</option>
                            <option value="menunggu_persetujuan" {{ request('status') == 'menunggu_persetujuan' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="w-full p-2.5 bg-lab-pink-btn text-white rounded-lg hover:bg-pink-700 transition shadow-sm font-bold text-sm">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- AKTIVITAS PEMINJAMAN --}}
        <div class="mb-10">
            <div class="flex items-center mb-6">
                <div class="bg-lab-pink-btn bg-pink-600 p-2 rounded-lg mr-3 shadow-sm text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Aktivitas Peminjaman</h2>
                    <p class="text-sm text-gray-500">Pantau request masuk dan barang yang sedang keluar.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5">
                {{-- LOOPING DATA DARI DATABASE --}}
                @forelse($peminjaman as $pinjam)
                <div class="bg-white rounded-xl shadow-md border-l-8 
                    {{ $pinjam->status == 'menunggu_persetujuan' ? 'border-yellow-400' : 
                      ($pinjam->status == 'disetujui' ? 'border-green-500' : 
                      ($pinjam->status == 'ditolak' ? 'border-red-500' : 'border-blue-500')) }} 
                    p-6 flex flex-col md:flex-row justify-between items-center hover:shadow-lg transition-all duration-200 relative overflow-hidden group">
                    
                    {{-- User Info --}}
                    <div class="flex items-center w-full md:w-1/4 mb-4 md:mb-0 relative z-10">
                        <div class="flex-shrink-0 h-10 w-10 mr-3">
                            <img class="h-10 w-10 rounded-full border-2 border-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($pinjam->user->name ?? 'X') }}&background=random" alt="">
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900">{{ $pinjam->user->name ?? 'User Terhapus' }}</div>
                            <div class="text-xs text-gray-500">{{ $pinjam->user->role ?? 'Anggota' }}</div>
                        </div>
                    </div>

                    {{-- Item Info --}}
                    <div class="flex items-center w-full md:w-1/3 mb-4 md:mb-0 relative z-10">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-xl mr-3 border border-gray-100">📦</div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">{{ $pinjam->item->nama_alat ?? 'Barang Terhapus' }}</h3>
                            <div class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded inline-block mt-1">{{ $pinjam->item->kode_alat ?? '-' }}</div>
                            <div class="text-[10px] text-gray-400 mt-1">
                                {{ $pinjam->tanggal_pinjam }} s/d {{ $pinjam->tanggal_kembali }}
                            </div>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="w-full md:w-1/4 text-left mb-4 md:mb-0 relative z-10 border-l border-gray-100 pl-4">
                        <span class="block text-[10px] text-gray-400 uppercase tracking-wider font-bold">Status</span>
                        @if($pinjam->status == 'menunggu_persetujuan')
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-700">MENUNGGU KONFIRMASI</span>
                        @elseif($pinjam->status == 'disetujui')
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700">DISETUJUI (DIPINJAM)</span>
                        @elseif($pinjam->status == 'ditolak')
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700">DITOLAK</span>
                        @elseif($pinjam->status == 'kembali')
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700">SELESAI</span>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="w-full md:w-1/6 flex justify-end gap-2 relative z-10">
                        @if($pinjam->status == 'menunggu_persetujuan')
                            {{-- Button TERIMA --}}
                            <form action="{{ route('peminjaman.confirm', $pinjam->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="disetujui">
                                <button type="submit" title="Terima" class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </form>
                            {{-- Button TOLAK --}}
                            <form action="{{ route('peminjaman.confirm', $pinjam->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" title="Tolak" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        @elseif($pinjam->status == 'disetujui')
                            {{-- Button TANDAI KEMBALI --}}
                            <form action="{{ route('peminjaman.confirm', $pinjam->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="kembali">
                                <button type="submit" title="Tandai Sudah Kembali" class="flex items-center gap-1 px-3 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors shadow-sm text-xs font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    Kembali
                                </button>
                            </form>
                        @else
                            {{-- No Action --}}
                            <span class="text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                    <div class="text-gray-400 mb-2">📭</div>
                    <p class="text-gray-500 font-medium">Belum ada data peminjaman.</p>
                </div>
                @endforelse
            </div>
            
            {{-- PAGINATION LINKS --}}
            <div class="mt-6">
                {{ $peminjaman->links() }}
            </div>
        </div>
    </div>
@endsection