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
                    {{-- TOMBOL TAMBAH PEMINJAM (Sudah Diperbaiki) --}}
                    <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-transparent rounded-xl font-bold text-xs text-lab-pink-btn uppercase tracking-widest hover:bg-pink-50 transition shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Peminjam
                    </a>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter Data Peminjaman
            </h3>
            
            <form action="{{ url()->current() }}" method="GET">
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
                        <label class="block text-xs font-medium text-gray-500 mb-1">Pilih Alat</label>
                        <select name="item_id" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                            <option value="">-- Semua Alat --</option>
                            {{-- Opsi ini statis, nanti bisa diganti dynamic looping $items --}}
                            <option value="1" {{ request('item_id') == '1' ? 'selected' : '' }}>Kamera Sony A7III</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <div class="w-full">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <select name="status" class="w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn">
                                <option value="">-- Semua Status --</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="p-2.5 bg-lab-pink-btn text-white rounded-lg hover:bg-pink-700 transition shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- INFO: Data di bawah ini masih statis (dummy HTML). 
             Nanti jika ingin menampilkan data asli dari database, 
             ganti bagian ini dengan looping: @foreach($loans as $loan) ... @endforeach 
        --}}

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
                {{-- CONTOH DATA DUMMY 1 --}}
                <div class="bg-white rounded-xl shadow-md border-l-8 border-yellow-400 p-6 flex flex-col md:flex-row justify-between items-center hover:shadow-lg transition-all duration-200 relative overflow-hidden group">
                    <div class="flex items-center w-full md:w-1/4 mb-4 md:mb-0 relative z-10">
                        <div class="flex-shrink-0 h-10 w-10 mr-3">
                            <img class="h-10 w-10 rounded-full border-2 border-yellow-200" src="https://ui-avatars.com/api/?name=Dani+Aditya&background=random" alt="">
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-900">Dani Aditya</div>
                            <div class="text-xs text-gray-500">Mahasiswa</div>
                        </div>
                    </div>
                    <div class="flex items-center w-full md:w-1/3 mb-4 md:mb-0 relative z-10">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center text-xl mr-3 border border-gray-100">📷</div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Kamera Sony A7III</h3>
                            <div class="text-xs font-mono text-gray-500 bg-gray-100 px-2 py-0.5 rounded inline-block mt-1">CAM-001</div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/4 text-left mb-4 md:mb-0 relative z-10 border-l border-gray-100 pl-4">
                        <span class="block text-[10px] text-gray-400 uppercase tracking-wider font-bold">Status</span>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-700">MENUNGGU KONFIRMASI</span>
                    </div>
                    <div class="w-full md:w-1/6 flex justify-end gap-2 relative z-10">
                        <button class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                        <button class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIWAYAT (DUMMY) --}}
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-700 mb-6">Riwayat Pengembalian (Contoh Tampilan)</h2>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-6 py-4">Siti Aminah</td>
                            <td class="px-6 py-4">Proyektor Epson</td>
                            <td class="px-6 py-4"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">SELESAI</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection