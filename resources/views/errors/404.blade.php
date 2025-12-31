<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - Lab PTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .text-shadow { text-shadow: 4px 4px 0px rgba(219, 39, 119, 0.2); }
    </style>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center overflow-hidden relative">

    <div class="absolute top-0 left-0 w-64 h-64 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 right-0 w-64 h-64 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-32 left-20 w-64 h-64 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10 text-center px-4">
        
        {{-- Angka 404 Besar --}}
        <h1 class="text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600 text-shadow mb-4">
            404
        </h1>

        <h2 class="text-3xl font-bold text-gray-800 mb-2">Ups! Halaman Hilang</h2>
        
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            Sepertinya halaman yang kamu cari tidak ada di sistem inventaris kami.
        </p>

        <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-3 rounded-full bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        blob: "blob 7s infinite",
                    },
                    keyframes: {
                        blob: {
                            "0%": { transform: "translate(0px, 0px) scale(1)" },
                            "33%": { transform: "translate(30px, -50px) scale(1.1)" },
                            "66%": { transform: "translate(-20px, 20px) scale(0.9)" },
                            "100%": { transform: "translate(0px, 0px) scale(1)" },
                        },
                    },
                },
            },
        };
    </script>
</body>
</html>