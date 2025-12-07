{{-- Menggunakan layout utama yang sama --}}
@extends('layouts.app')

{{-- Isi konten utama --}}
@section('content')

    {{-- HEADER HALAMAN & TOMBOL TAMBAH --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-pink-800">
            Data Peminjaman
        </h2>
        
        <a href="#" class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 active:bg-pink-800 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Peminjam
        </a>
    </div>

    {{-- KONTAINER TABEL --}}
    <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-200">
                
                {{-- HEADER TABEL --}}
                <thead class="bg-pink-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-pink-700 uppercase tracking-wider w-16">
                            No
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">
                            Nama Peminjam
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">
                            Item / Alat
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">
                            Tgl Pinjam
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">
                            Tgl Kembali
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-pink-700 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="relative px-6 py-4">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                
                {{-- BODY TABEL --}}
                <tbody class="bg-white divide-y divide-gray-200">

                    {{-- 
                        CATATAN UNTUK PENGEMBANGAN BACKEND:
                        Nanti ganti bagian ini dengan foreach:
                        @foreach($peminjaman as $index => $item)
                        ...
                        @endforeach
                    --}}

                    <!-- CONTOH DATA 1: STATUS DIPINJAM -->
                    <tr class="hover:bg-pink-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            1
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name=Budi+Santoso&background=random" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Budi Santoso</div>
                                    <div class="text-xs text-gray-500">Mahasiswa</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            Laptop Asus ROG
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            01 Des 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            - {{-- Kosong karena belum kembali --}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                Dipinjam
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-3" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                        </td>
                    </tr>

                    <!-- CONTOH DATA 2: STATUS DIKEMBALIKAN -->
                    <tr class="hover:bg-pink-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            2
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name=Siti+Aminah&background=random" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Siti Aminah</div>
                                    <div class="text-xs text-gray-500">Dosen</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            Proyektor Epson
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            28 Nov 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            30 Nov 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                Dikembalikan
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-gray-400 hover:text-gray-600 cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </td>
                    </tr>

                    <!-- CONTOH DATA 3: STATUS TERLAMBAT (Opsional) -->
                    <tr class="hover:bg-pink-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            3
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name=Rizky+Febian&background=random" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">Rizky Febian</div>
                                    <div class="text-xs text-gray-500">Mahasiswa</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            Arduino Uno Kit
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            15 Okt 2023
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            -
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                Terlambat
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-pink-600 hover:text-pink-900 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        
        {{-- PAGINATION FOOTER (Opsional) --}}
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">3</span> dari <span class="font-medium">20</span> data
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection