<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Lab PTIK</title>
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Konfigurasi Tema Warna --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#FCE7F3', 
                        'lab-pink-dark': '#FF91A4', 
                        'lab-text': '#590D22', 
                        'lab-pink-btn': '#DB2777', 
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
    </style>
</head>

<body class="bg-white font-poppins antialiased text-gray-800">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
            <!-- Header Sidebar -->
            <div class="h-16 flex items-center justify-center border-b border-gray-200">
                <h1 class="text-xl font-bold text-lab-text">Laboratorium PTIK</h1>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 mt-6 px-4 space-y-2">
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('dashboard_admin') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard_admin') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard Admin
                    </a>
                    <a href="{{ route('items.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('items.*') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Inventaris
                    </a>

                    {{-- 3. MENU MEMBER --}}
                    <a href="{{ route('members.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('members*') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                     d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                             </svg>
                        Anggota
                    </a>

                    {{-- 4. MENU PEMINJAMAN DENGAN NOTIFIKASI --}}
                    @php
                        // Menghitung jumlah peminjaman yang statusnya 'pending'
                        $pendingCount = \App\Models\Peminjaman::where('status', 'pending')->count();
                    @endphp

                    <a href="{{ route('peminjaman') }}"
                        class="flex items-center justify-between px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('peminjaman') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <div class="flex items-center">
                            {{-- Ikon Peminjaman (Sama persis dengan file lama) --}}
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Peminjaman
                        </div>

                        {{-- Tampilkan Badge Merah jika ada pending --}}
                        @if($pendingCount > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full animate-pulse shadow-sm">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                @endif

                {{-- MENU KHUSUS MAHASISWA DAN DOSEN --}}
                @if (Auth::check() && in_array(Auth::user()->role, ['mahasiswa', 'dosen']))
                    <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('student.dashboard') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('student.inventory') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('student.inventory') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Stok Gudang
                    </a>
                    {{-- 1. LOGIKA PHP: Hitung jumlah barang TERLAMBAT milik User Login --}}
                    @php
                        $lateCount = 0;
                        if(Auth::check()) {
                            $lateCount = \App\Models\Peminjaman::where('user_id', Auth::id())
                                            ->where('status', 'terlambat')
                                            ->count();
                        }
                    @endphp

                    {{-- 2. TAMPILAN MENU SIDEBAR --}}
                    <a href="{{ route('student.loans') }}"
                    class="flex items-center justify-between px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('student.loans') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        
                        <div class="flex items-center">
                            {{-- Ikon Peminjaman --}}
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pinjaman Saya
                        </div>

                        {{-- 3. BADGE MERAH (Hanya muncul jika ada yang terlambat) --}}
                        @if($lateCount > 0)
                            <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full animate-pulse shadow-sm border border-red-400">
                                {{ $lateCount }}
                            </span>
                        @endif
                    </a>
                @endif
            </nav>

            
            <!-- Tombol Logout di Bawah Sidebar -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        <!-- END SIDEBAR -->

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- HEADER ATAS -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm">
                <button class="md:hidden text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="flex-1"></div> 
                <!-- Profil Admin -->
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col text-right">
                        <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Guest' }}</span>
                        <span class="text-xs text-gray-500 capitalize">{{ ucfirst(Auth::user()->role) ?? 'Visitor' }}</span>
                    </div>
                    
                    <div class="relative group h-full flex items-center">
                        <button class="flex items-center focus:outline-none">
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-lab-text" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'G') }}&background=FFC0CB&color=590D22" 
                                 alt="Admin">
                        </button>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>