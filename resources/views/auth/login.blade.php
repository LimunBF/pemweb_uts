<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Lab PTIK</title>
    
    <!-- Menggunakan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Konfigurasi Warna Pink Lab -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#FFC0CB',       // Pink Muda (Background Header)
                        'lab-pink-dark': '#FF91A4',  // Pink Sedang
                        'lab-pink-btn': '#DB2777',   // Pink Tua (Tombol)
                        'lab-text': '#881337',       // Merah Gelap (Teks Judul)
                    },
                    fontFamily: {
                        'sans': ['ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center font-sans">

    <!-- Kartu Login -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-pink-100 transform transition-all hover:scale-[1.01] duration-300">
        
        <!-- HEADER (Warna Pink) -->
        <div class="bg-lab-pink p-8 text-center relative overflow-hidden">
            <!-- Hiasan lingkaran background (opsional) -->
            <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-white rounded-full transform scale-150 translate-x-10 -translate-y-10"></div>
            
            <div class="relative z-10">
                <div class="mx-auto bg-white w-20 h-20 rounded-full flex items-center justify-center text-lab-pink-btn mb-4 shadow-md ring-4 ring-pink-200">
                    <!-- Icon Kunci / User -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-lab-text tracking-wide">Lab PTIK</h2>
                <p class="text-gray-700 text-sm mt-2 font-medium">Sistem Informasi Inventaris</p>
            </div>
        </div>

        <!-- FORMULIR -->
        <div class="p-8 pt-10">
            
            <!-- MENAMPILKAN ERROR (Jika login gagal) -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm shadow-sm flex items-start">
                    <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="font-bold">Gagal Masuk</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf <!-- Token Keamanan Wajib -->

                <!-- Input Email -->
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-1">Email Administrator</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" required autofocus
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 transition-all bg-gray-50 focus:bg-white"
                            placeholder="admin@lab.com">
                    </div>
                </div>

                <!-- Input Password -->
                <div class="mb-8">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2 ml-1">Kata Sandi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 transition-all bg-gray-50 focus:bg-white"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" 
                    class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1 focus:ring-4 focus:ring-pink-300">
                    Masuk Sekarang
                </button>
            </form>
        </div>
        
        <!-- Footer Kecil -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-500">
                Lupa password? Hubungi <a href="#" class="text-lab-pink-btn hover:underline font-bold">Kepala Lab</a>
            </p>
        </div>

    </div>

</body>
</html>