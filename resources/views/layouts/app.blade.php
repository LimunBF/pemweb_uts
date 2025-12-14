<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Lab PTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                {{-- MENU KHUSUS ADMIN --}}
                @if (Auth::check() && Auth::user()->role == 'admin')
                    {{-- 1. MENU DASHBOARD --}}
                    <a href="{{ route('dashboard_admin') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard_admin') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">

                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    {{-- 2. MENU INVENTARIS (Perhatikan routeIs('items.*')) --}}
                    {{-- 'items.*' artinya aktif untuk items.index, items.create, items.edit, dll --}}
                    <a href="{{ route('items.index') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('items.*') || request()->routeIs('inventaris.index') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">

                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
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
                        Members
                    </a>

                    {{-- 4. MENU PEMINJAMAN --}}
                    <a href="{{ route('peminjaman') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('peminjaman') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Peminjaman
                    </a>

                @endif

                {{-- MENU KHUSUS MAHASISWA / USER --}}
                @if (Auth::check() && Auth::user()->role == 'mahasiswa')
                    {{-- 1. Dashboard (Katalog) --}}
                    <a href="{{ route('student.dashboard') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('student.dashboard') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Dashboard Utama
                    </a>

                    {{-- 2. Inventaris (Tabel) --}}
                    <a href="{{ route('student.inventory') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('student.inventory') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Cek Stok Gudang
                    </a>

                    {{-- 3. Peminjaman Saya --}}
                    <a href="{{ route('student.loans') }}"
                        class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('student.loans') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pinjaman Saya
                    </a>
                @endif
            </nav>

            
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- HEADER -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm">
                <!-- Tombol Mobile -->
                <button class="md:hidden text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Spacer -->
                <div class="flex-1"></div>

                <!-- Profil Admin -->
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col text-right">
                        <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Guest' }}</span>
                        <span class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'Visitor' }}</span>
                    </div>

                    <!-- Dropdown User -->
                    <div class="relative group h-full flex items-center">
                        <button class="flex items-center focus:outline-none">
                            <!-- Border avatar disesuaikan dengan palette -->
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-lab-text"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'G') }}&background=FFC0CB&color=590D22"
                                alt="Admin">
                        </button>
                        
                        
                        <div class="absolute right-0 top-full pt-4 w-48 hidden group-hover:block z-50">
                            <div class="bg-white rounded-md shadow-lg py-1 border border-gray-100">
                                <!-- FORM LOGOUT DROPDOWN -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50 cursor-pointer">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT AREA -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>