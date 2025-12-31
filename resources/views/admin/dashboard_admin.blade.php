@extends('layouts.app')

@section('content')
<div class="container mx-auto">

    {{-- 1. Banner Selamat Datang --}}
    <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-8 mb-8 text-white shadow-lg flex items-center justify-between relative overflow-hidden animate-fade-in-up">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold">Selamat Datang, {{ Str::words($user_name ?? Auth::user()->name, 1, '') }}! 👋</h1>
            <p class="mt-2 text-pink-100 opacity-90">Ringkasan status inventaris dan aktivitas laboratorium hari ini.</p>
        </div>
        {{-- Hiasan Background Abstrak --}}
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- === KOLOM KIRI (Profil & Chart Status) === --}}
        <div class="lg:col-span-1 flex flex-col gap-6 animate-fade-in-up" style="animation-delay: 0.1s;">
            
            {{-- KARTU PROFIL --}}
            <div class="bg-white rounded-2xl shadow-md border border-pink-100 p-6 relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-lab-text rounded-t-2xl"></div>
                
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil Administrator
                </h3>

                <div class="space-y-5">
                    {{-- Nama --}}
                    <div class="border-b border-gray-100 pb-2 group">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Nama Lengkap</label>
                        <div class="text-lg font-medium text-lab-text group-hover:text-lab-pink-btn transition-colors">{{ $user_name ?? Auth::user()->name }}</div>
                    </div>

                    {{-- Email --}}
                    <div class="border-b border-gray-100 pb-2">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Email Akun</label>
                        <div class="text-base text-gray-600 font-mono">{{ Auth::user()->email }}</div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Status Sistem</label>
                        <div class="flex items-center mt-1">
                            <span class="h-3 w-3 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            <span class="text-sm font-medium text-gray-600">Online & Active</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHART 2: DOUGHNUT STATUS --}}
            <div class="bg-white p-6 rounded-2xl shadow-md border border-pink-100 flex flex-col items-center justify-center text-center">
                <h4 class="font-bold text-gray-700 mb-4 w-full text-left flex items-center">
                    <svg class="w-5 h-5 mr-2 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    Rasio Inventaris
                </h4>
                <div class="relative w-48 h-48">
                    <canvas id="statusChart"></canvas>
                </div>
                <div class="mt-4 w-full grid grid-cols-2 gap-2 text-xs">
                    <div class="bg-green-50 p-2 rounded-lg text-green-700 font-bold border border-green-100">
                        {{ $barang_tersedia }} Tersedia
                    </div>
                    <div class="bg-yellow-50 p-2 rounded-lg text-yellow-700 font-bold border border-yellow-100">
                        {{ $barang_dipinjam }} Dipinjam
                    </div>
                </div>
            </div>

        </div>

        {{-- === KOLOM KANAN === --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- 2. Baris Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 animate-fade-in-up" style="animation-delay: 0.2s;">
                {{-- Card Total --}}
                <div class="bg-white rounded-2xl p-5 shadow-md border border-pink-100 hover:shadow-lg transition-all flex flex-col items-center justify-center text-center group">
                    <div class="bg-lab-pink p-3 rounded-full mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div class="text-4xl font-bold text-lab-text mb-1">{{ $total_barang }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Aset</div>
                </div>
                {{-- Card Dipinjam --}}
                <div class="bg-white rounded-2xl p-5 shadow-md border border-pink-100 hover:shadow-lg transition-all flex flex-col items-center justify-center text-center group">
                    <div class="bg-orange-100 p-3 rounded-full mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-4xl font-bold text-orange-500 mb-1">{{ $barang_dipinjam }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Sedang Dipinjam</div>
                </div>
                {{-- Card Tersedia --}}
                <div class="bg-white rounded-2xl p-5 shadow-md border border-pink-100 hover:shadow-lg transition-all flex flex-col items-center justify-center text-center group">
                    <div class="bg-green-100 p-3 rounded-full mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-4xl font-bold text-green-600 mb-1">{{ $barang_tersedia }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Stok Tersedia</div>
                </div>
            </div>

            {{-- 3. Menu Cepat (PINDAH KE ATAS - POSISI 2) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                
                {{-- Kelola Barang --}}
                <a href="{{ route('items.index') }}" class="group bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex items-center hover:shadow-xl hover:border-lab-pink-btn transition-all duration-300">
                    <div class="p-4 bg-lab-pink rounded-xl text-lab-pink-btn mr-5 group-hover:bg-lab-pink-btn group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-lab-pink-btn transition-colors">Kelola Inventaris</h3>
                        <p class="text-xs text-gray-500">Tambah, edit, atau hapus data barang.</p>
                    </div>
                </a>

                {{-- Daftar Peminjaman --}}
                <a href="{{ route('peminjaman') }}" class="group bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex items-center hover:shadow-xl hover:border-blue-500 transition-all duration-300">
                    <div class="p-4 bg-blue-50 rounded-xl text-blue-600 mr-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Daftar Peminjaman</h3>
                        <p class="text-xs text-gray-500">Lihat request dan riwayat.</p>
                    </div>
                </a>

            </div>

            {{-- 4. CHART 1: LINE CHART (PINDAH KE BAWAH - POSISI 3) --}}
            <div class="bg-white p-6 rounded-2xl shadow-md border border-pink-100 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-bold text-gray-700 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        Tren Peminjaman
                    </h4>
                    <div class="bg-pink-50 text-lab-pink-btn px-3 py-1 rounded-lg text-xs font-bold">
                        Tahun {{ date('Y') }}
                    </div>
                </div>
                <div class="relative h-72 w-full">
                    <canvas id="loanChart"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- 1. Line Chart (Tren Peminjaman) ---
    const ctxLoan = document.getElementById('loanChart').getContext('2d');
    let gradientLoan = ctxLoan.createLinearGradient(0, 0, 0, 400);
    gradientLoan.addColorStop(0, 'rgba(219, 39, 119, 0.2)'); 
    gradientLoan.addColorStop(1, 'rgba(219, 39, 119, 0)');

    new Chart(ctxLoan, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($chart_peminjaman),
                borderColor: '#DB2777',
                backgroundColor: gradientLoan,
                borderWidth: 3,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#DB2777',
                pointHoverRadius: 6,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [2, 4], color: '#f3f4f6' },
                    ticks: { precision: 0 }
                },
                x: { grid: { display: false } }
            }
        }
    });

    // --- 2. Doughnut Chart (Status Barang) ---
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Tersedia', 'Dipinjam'],
            datasets: [{
                data: [{{ $chart_status['tersedia'] }}, {{ $chart_status['dipinjam'] }}],
                backgroundColor: ['#10B981', '#F59E0B'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            cutout: '70%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
</script>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
</style>
@endsection