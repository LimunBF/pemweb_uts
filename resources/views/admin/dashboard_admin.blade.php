@extends('layouts.app')

@section('content')
    <div class="text-center mb-10 mt-2">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
            Selamat Datang "<span class="italic text-lab-text">{{ $user_name }}</span>"
        </h2>
        <p class="text-gray-500">
            Di sini Anda bisa melihat ringkasan status inventaris laboratorium.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        
        <div class="bg-lab-pink rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow flex flex-col justify-between h-64 border border-pink-200">
            <h3 class="text-xl font-semibold text-lab-pink-btn uppercase tracking-wider">Total Barang</h3>
            <div class="text-7xl font-bold text-lab-pink-btn">
                {{ $total_barang }}
            </div>
            <div class="text-m text-lab-text opacity-75">Unit Item</div>
        </div>

        <div class="bg-lab-pink rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow flex flex-col justify-between h-64 border border-pink-200">
            <h3 class="text-xl font-semibold text-lab-pink-btn uppercase tracking-wider">Sedang Dipinjam</h3>
            <div class="text-7xl font-bold text-lab-pink-btn">
                {{ $barang_dipinjam }}
            </div>
            <div class="text-m text-lab-text opacity-75">Unit Item</div>
        </div>

        <div class="bg-lab-pink rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow flex flex-col justify-between h-64 border border-pink-200">
            <h3 class="text-xl font-semibold text-lab-pink-btn uppercase tracking-wider">Barang Tersedia</h3>
            <div class="text-7xl font-bold text-lab-pink-btn">
                {{ $barang_tersedia }}
            </div>
            <div class="text-m text-lab-text opacity-75">Siap Digunakan</div>
        </div>

    </div>
@endsection