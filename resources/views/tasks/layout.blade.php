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
                        'lab-pink': '#FCE7F3',       // Pink Muda (Kartu & Hover Sidebar)
                        'lab-pink-dark': '#FF91A4',  // Pink Tua (Menu Aktif/Secondary)
                        'lab-text': '#590D22',       // Merah Gelap (Teks Kontras & Menu Aktif Utama)
                        'lab-pink-btn':'#DB2777',    // Button
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
                
                <!-- 1. Menu Dashboard -->
                <!-- Logika: Jika route saat ini adalah 'dashboard_admin', pakai style aktif (bg-lab-text text-white), jika tidak pakai style biasa -->
                <a href="{{ route('dashboard_admin') }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard_admin') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                    
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <!-- 2. Menu Inventaris -->
                <!-- Ganti '#' dengan route('inventaris') jika sudah ada rutenya -->
                <a href="#" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('inventaris*') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                    
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Inventaris
                </a>

                <!-- 3. Menu Peminjaman -->
                <!-- Mengecek apakah halaman yang dibuka bernama 'peminjaman' -->
                <a href="{{ Route::has('peminjaman') ? route('peminjaman') : '#' }}" 
                   class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('peminjaman*') ? 'bg-lab-text text-white shadow-md' : 'text-gray-600 hover:bg-lab-pink hover:text-gray-900' }}">
                   
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Peminjaman
                </a>

            </nav>
            
            <!-- Tombol Logout -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- HEADER -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm">
                <!-- Tombol Mobile Menu -->
                <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="flex-1"></div> 
                
                <!-- Profil Admin -->
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col text-right hidden sm:block">
                        <span class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Admin Lab' }}</span>
                        <span class="text-xs text-gray-500">Administrator</span>
                    </div>
                    
                    <div class="relative group">
                        <button class="flex items-center focus:outline-none">
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-lab-text" 
                                 src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=FFC0CB&color=590D22" 
                                 alt="Admin">
                        </button>
                        <!-- Dropdown Logout (Opsional) -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block border border-gray-100 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- AREA KONTEN -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-8">
                <!-- Disini konten dari @section('content') di setiap halaman akan muncul -->
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>