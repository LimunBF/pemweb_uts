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
                        'lab-pink-dark': '#FF91A4',  // Pink Tua (Menu Aktif)
                        'lab-text': '#590D22',       // Merah Gelap (Teks Angka agar kontras)
                        'lab-pink-btn':'#DB2777', //button
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
            <div class="h-16 flex items-center justify-center border-b border-gray-200">
                <h1 class="text-xl font-bold text-lab-text">Laboratorium PTIK</h1> 
            </div>

            <nav class="flex-1 mt-6 px-4 space-y-2">
                <!-- Menu Dashboard -->
                <a href="{{ route('dashboard_admin') }}" class="flex items-center px-4 py-3 bg-lab-text text-white rounded-lg shadow-md transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <!-- Menu Inventaris -->
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-lab-pink hover:text-gray-900 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Inventaris
                </a>

                <!-- Menu Peminjaman -->
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-lab-pink hover:text-gray-900 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Peminjaman
                </a>
                <!-- Menu Daftar Anggota -->
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-lab-pink hover:text-gray-900 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    Anggota
                </a>
            </nav>

                

            <!-- Tombol Logout di Bawah Sidebar -->
            <div class="p-4 border-t border-gray-200">
                <a href="#" class="flex items-center px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <!-- HEADER ATAS -->
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm">
                <!-- Tombol Menu Mobile -->
                <button class="md:hidden text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <!-- Spacer -->
                <div class="flex-1"></div> 

                <!-- Profil Admin -->
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col text-right">
                        <span class="text-sm font-semibold text-gray-800">{{ $user_name }}</span>
                        <span class="text-xs text-gray-500">Administrator</span>
                    </div>
                    <div class="relative">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-lab-text" 
                             src="https://ui-avatars.com/api/?name={{ urlencode($user_name) }}&background=FFC0CB&color=590D22" 
                             alt="Admin">
                    </div>
                </div>
            </header>

            <!-- AREA KONTEN DASHBOARD -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-8">
                
                <!-- Greeting Section -->
                <div class="text-center mb-10 mt-2">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">
                        Selamat Datang "<span class="italic text-lab-text">{{ $user_name }}</span>"
                    </h2>
                    <p class="text-gray-500">
                        Di sini Anda bisa melihat ringkasan status inventaris laboratorium.
                    </p>
                </div>

                <!-- Grid Kartu Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                    
                    <!-- Kartu 1: Total Barang -->
                    <div class="bg-lab-pink rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow flex flex-col justify-between h-64 border border-pink-200">
                        <h3 class="text-xl font-semibold text-lab-pink-btn uppercase tracking-wider">Total Barang</h3>
                        <div class="text-7xl font-bold text-lab-pink-btn">
                            {{ $total_barang }}
                        </div>
                        <div class="text-m text-lab-text opacity-75">Unit Item</div>
                    </div>

                    <!-- Kartu 2: Barang Dipinjam -->
                    <div class="bg-lab-pink rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow flex flex-col justify-between h-64 border border-pink-200">
                        <h3 class="text-xl font-semibold text-lab-pink-btn uppercase tracking-wider">Sedang Dipinjam</h3>
                        <div class="text-7xl font-bold text-lab-pink-btn">
                            {{ $barang_dipinjam }}
                        </div>
                        <div class="text-m text-lab-text opacity-75">Unit Item</div>
                    </div>

                    <!-- Kartu 3: Barang Tersedia -->
                    <div class="bg-lab-pink rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow flex flex-col justify-between h-64 border border-pink-200">
                        <h3 class="text-xl font-semibold text-lab-pink-btn uppercase tracking-wider">Barang Tersedia</h3>
                        <div class="text-7xl font-bold text-lab-pink-btn">
                            {{ $barang_tersedia }}
                        </div>
                        <div class="text-m text-lab-text opacity-75">Siap Digunakan</div>
                    </div>

                </div>

            </main>
        </div>
    </div>
</body>
</html>