<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Lab PTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink-dark': '#FF8FA3',   // Warna Header & Menu Aktif
                        'lab-pink-light': '#FFC2D1',  // Warna Sidebar & Kartu
                        'lab-text': '#590D22',        // Warna Teks (Merah Gelap)
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white">

    <header class="bg-lab-pink-dark text-white p-4 flex justify-between items-center shadow-md">
        <h1 class="text-2xl font-bold ml-4">Laboratorium Komputer PTIK</h1>
        <div class="flex items-center mr-8">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-lab-pink-dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <span class="ml-3 font-semibold text-lg">{{ $user_name }}</span>
        </div>
    </header>

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-lab-pink-light pt-6 pb-10 flex flex-col">
            <nav class="flex-1 px-4 space-y-2">
                <a href="#" class="flex items-center px-4 py-3 bg-lab-pink-dark text-white rounded-lg shadow-sm">
                    <span class="font-medium">Beranda</span>
                </a>
                
                <a href="#" class="flex items-center px-4 py-3 text-lab-text hover:bg-white hover:bg-opacity-50 rounded-lg transition">
                    <span class="font-medium">Inventaris</span>
                </a>
                
                <a href="#" class="flex items-center px-4 py-3 text-lab-text hover:bg-white hover:bg-opacity-50 rounded-lg transition">
                    <span class="font-medium">Pinjam</span>
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-lab-text hover:bg-white hover:bg-opacity-50 rounded-lg transition mt-8">
                    <span class="font-medium">Logout</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-10 bg-white">
            
            <div class="text-center mb-12 mt-4">
                <h2 class="text-4xl font-bold text-lab-text mb-2">
                    Selamat Datang "<span class="italic">{{ $user_name }}</span>"
                </h2>
                <p class="text-lg text-lab-text">
                    disini Anda bisa melihat ringkasan inventaris
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-8">
                
                <div class="bg-lab-pink-light rounded-lg p-8 text-center shadow-sm flex flex-col justify-between h-64">
                    <h3 class="text-2xl text-lab-text mb-4">Total Barang</h3>
                    <div class="text-6xl font-bold text-lab-text mb-4">
                        {{ $total_barang }}
                    </div>
                </div>

                <div class="bg-lab-pink-light rounded-lg p-8 text-center shadow-sm flex flex-col justify-between h-64">
                    <h3 class="text-2xl text-lab-text mb-4">Barang <br> Dipinjam</h3>
                    <div class="text-6xl font-bold text-lab-text mb-4">
                        {{ $barang_dipinjam }}
                    </div>
                </div>

                <div class="bg-lab-pink-light rounded-lg p-8 text-center shadow-sm flex flex-col justify-between h-64">
                    <h3 class="text-2xl text-lab-text mb-4">Barang <br> Tersedia</h3>
                    <div class="text-6xl font-bold text-lab-text mb-4">
                        {{ $barang_tersedia }}
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>