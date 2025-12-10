@extends('layouts.app')

@section('content')
<div class="container mx-auto">

    {{-- Banner Selamat Datang --}}
    <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-8 mb-8 text-white shadow-lg flex items-center justify-between relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="mt-2 text-pink-100 opacity-90">Selamat datang di Dashboard Peminjaman Laboratorium PTIK.</p>
        </div>
        
        {{-- Hiasan Background Abstrak --}}
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: KARTU PROFIL (Sesuai Sketsa: Nama, NIM, No WA) --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-md border border-pink-100 p-6 h-full relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-lab-text rounded-t-2xl"></div>
                
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Mahasiswa
                </h3>

                <div class="space-y-5">
                    {{-- Nama --}}
                    <div class="border-b border-gray-100 pb-2">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Nama Lengkap</label>
                        <div class="text-lg font-medium text-lab-text">{{ Auth::user()->name }}</div>
                    </div>

                    {{-- NIM --}}
                    <div class="border-b border-gray-100 pb-2">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">NIM (Identitas)</label>
                        <div class="text-lg font-medium text-gray-700 font-mono">
                            {{ Auth::user()->identity_number ?? 'Belum Diisi' }}
                        </div>
                    </div>

                    {{-- No WA --}}
                    <div class="border-b border-gray-100 pb-2">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">No. WhatsApp</label>
                        <div class="text-lg font-medium text-gray-700">
                            {{ Auth::user()->contact ?? 'Belum Diisi' }}
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Email</label>
                        <div class="text-base text-gray-600">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: MENU AKSI (Sesuai Sketsa: Gambar "Peminjaman" & "Riwayat") --}}
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            {{-- Tombol Besar: PEMINJAMAN (Gambar "Kucing"/Objek Besar di sketsa) --}}
            <a href="{{ route('student.loan.form') }}" class="group relative bg-white rounded-2xl shadow-md border border-pink-100 p-8 flex flex-col md:flex-row items-center justify-between hover:shadow-xl hover:border-lab-pink-btn transition-all duration-300 cursor-pointer overflow-hidden">
                
                {{-- Efek Hover Background --}}
                <div class="absolute inset-0 bg-lab-pink opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>

                <div class="relative z-10 text-center md:text-left mb-6 md:mb-0">
                    <h2 class="text-3xl font-bold text-lab-text mb-2 group-hover:text-lab-pink-btn transition-colors">
                        Mulai Peminjaman
                    </h2>
                    <p class="text-gray-500 max-w-md">
                        Isi formulir pengajuan untuk meminjam alat laboratorium sesuai kebutuhan praktikum Anda.
                    </p>
                    {{-- UPDATE LINK DI SINI --}}
                    <span class="mt-4 inline-block px-6 py-2 bg-lab-pink-btn text-white rounded-full text-sm font-semibold shadow-md group-hover:bg-lab-text transition-colors">
                        Isi Formulir &rarr;
                    </span>
                </div>

                {{-- Ikon Besar (Representasi gambar di sketsa) --}}
                <div class="relative z-10 w-32 h-32 bg-lab-pink rounded-full flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-16 h-16 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </a>

            {{-- Tombol Kedua: RIWAYAT PEMINJAMAN (Sesuai sketsa bawah) --}}
            <a href="{{ route('student.loans') }}" class="group bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex items-center hover:shadow-lg hover:border-blue-300 transition-all duration-300">
                <div class="p-4 bg-blue-50 rounded-xl text-blue-600 mr-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-700 transition-colors">Riwayat Peminjaman</h3>
                    <p class="text-sm text-gray-500">Lihat status barang yang sedang dipinjam & deadline.</p>
                </div>
                <div class="ml-auto text-gray-300 group-hover:text-blue-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection