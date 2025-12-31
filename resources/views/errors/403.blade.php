<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Lab PTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#FCE7F3',
                        'lab-pink-btn': '#DB2777',
                        'lab-text': '#590D22',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'shake': 'shake 0.82s cubic-bezier(.36,.07,.19,.97) both',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-gray-50 overflow-hidden h-screen flex items-center justify-center relative">

    {{-- Background Blobs --}}
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>

    <div class="text-center z-10 px-4">
        
        {{-- Ilustrasi Gembok (SVG) --}}
        <div class="relative w-64 h-64 mx-auto mb-6 animate-float">
            {{-- Lingkaran Background --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-pink-100 to-purple-50 rounded-full shadow-lg border-4 border-white"></div>
            
            {{-- Icon Gembok --}}
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-32 h-32 text-lab-pink-btn drop-shadow-md transform transition hover:scale-110 duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>

            {{-- Badge '403' Kecil --}}
            <div class="absolute top-0 right-0 bg-red-500 text-white font-bold text-xl px-4 py-2 rounded-full shadow-lg transform rotate-12 border-4 border-white">
                403
            </div>
        </div>

        {{-- Pesan Error --}}
        <h1 class="text-4xl md:text-5xl font-extrabold text-lab-text mb-2">Ups! Akses Ditolak</h1>
        <p class="text-gray-500 text-lg md:text-xl max-w-lg mx-auto mb-8 leading-relaxed">
            Maaf, kamu tidak memiliki izin untuk masuk ke area rahasia ini. <br>
            <span class="text-sm italic text-gray-400">(Hanya Admin yang boleh lewat sini 🤫)</span>
        </p>

        {{-- Tombol Aksi --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url('/') }}" class="px-8 py-3 rounded-full bg-lab-pink-btn text-white font-bold shadow-lg hover:bg-pink-700 hover:shadow-pink-200 transition transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Kembali ke Beranda
            </a>
            
            <a href="javascript:history.back()" class="px-8 py-3 rounded-full bg-white text-gray-600 font-bold border-2 border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Balik Kanan
            </a>
        </div>
        
    </div>

</body>
</html>