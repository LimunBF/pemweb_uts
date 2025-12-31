<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Lab PTIK</title>
    <link rel="icon" href="{{ asset('templates/logo_ptik.png') }}" type="image/png">
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
                    fontFamily: { 'poppins': ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        
        .blob { position: absolute; filter: blur(40px); z-index: -1; opacity: 0.4; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-white text-gray-800 overflow-x-hidden">

    {{-- NAVBAR --}}
    <nav class="container mx-auto px-6 py-6 flex justify-between items-center relative z-20">
        <div class="flex items-center gap-3">
            <img src="{{ asset('templates/logo_ptik.png') }}" alt="Logo" class="h-10 w-auto">
            <span class="text-xl font-bold text-lab-text tracking-wide hidden sm:block">Lab PTIK</span>
        </div>
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-lab-pink-btn transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-lab-pink-btn transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-lab-pink-btn text-white text-sm font-bold shadow-lg hover:bg-pink-700 hover:shadow-pink-200 transition transform hover:-translate-y-0.5">Daftar</a>
                @endauth
            @endif
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <div class="container mx-auto px-6 pt-10 pb-20 flex flex-col-reverse lg:flex-row items-center relative">
        
        {{-- Dekorasi Background --}}
        <div class="blob bg-pink-300 w-96 h-96 rounded-full top-0 left-0 -translate-x-1/2 -translate-y-1/2"></div>
        <div class="blob bg-purple-200 w-80 h-80 rounded-full bottom-0 right-0 translate-x-1/3 translate-y-1/3"></div>

        {{-- Teks Kiri --}}
        <div class="w-full lg:w-1/2 text-center lg:text-left mt-12 lg:mt-0 z-10">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-bold tracking-wider text-pink-600 uppercase bg-pink-100 rounded-full">
                Sistem Informasi Inventaris
            </div>
            <h1 class="text-4xl lg:text-6xl font-extrabold text-lab-text leading-tight mb-6">
                Kelola Peminjaman <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-lab-pink-btn to-purple-600">Lebih Mudah.</span>
            </h1>
            <p class="text-gray-500 text-lg mb-8 leading-relaxed max-w-lg mx-auto lg:mx-0">
                Platform terintegrasi untuk mahasiswa dan dosen Pendidikan TIK. Cek ketersediaan alat, ajukan peminjaman, dan pantau status secara realtime.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl bg-lab-text text-white font-bold shadow-xl hover:bg-gray-900 transition flex items-center justify-center gap-2 group">
                    Mulai Pinjam
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <a href="#fitur" class="px-8 py-4 rounded-xl bg-white text-gray-700 border border-gray-200 font-bold hover:bg-gray-50 transition flex items-center justify-center">
                    Pelajari Fitur
                </a>
            </div>

            {{-- Stat Kecil --}}
            <div class="mt-12 flex items-center justify-center lg:justify-start gap-8 text-gray-400">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-green-100 rounded-lg text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <span class="text-sm font-semibold">Respon Cepat</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <span class="text-sm font-semibold">Realtime 24/7</span>
                </div>
            </div>
        </div>

        {{-- Ilustrasi Kanan (Menggunakan Maskot Kucing Lagi agar Konsisten) --}}
        <div class="w-full lg:w-1/2 flex justify-center relative z-10">
            {{-- Lingkaran Belakang --}}
            <div class="absolute w-[400px] h-[400px] bg-gradient-to-tr from-pink-100 to-purple-100 rounded-full -z-10 blur-xl opacity-70"></div>
            
            <div class="relative animate-float cursor-pointer group">
                {{-- Chat Bubble Kucing --}}
                <div class="absolute -top-12 -left-12 bg-white p-4 rounded-2xl rounded-br-none shadow-lg border-2 border-lab-pink-btn transform -rotate-6 z-20 group-hover:scale-110 transition-transform">
                    <p class="text-sm font-bold text-lab-text">👋 Hai! Mau pinjam apa?</p>
                </div>

                {{-- SVG KUCING BESAR --}}
                <svg viewBox="0 0 200 180" class="w-80 h-auto drop-shadow-2xl">
                    <g class="cat-head transition-transform duration-300 group-hover:-translate-y-2">
                        <path d="M 30 60 L 10 10 L 70 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 28 55 L 18 25 L 55 45 Z" fill="#FCE7F3"/>
                        <path d="M 170 60 L 190 10 L 130 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 172 55 L 182 25 L 145 45 Z" fill="#FCE7F3"/>
                        <ellipse cx="100" cy="100" rx="85" ry="75" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 35 155 Q 100 190 165 155 L 165 180 Q 100 215 35 180 Z" fill="#DB2777"/>
                        <g id="eyes">
                            <ellipse cx="60" cy="90" rx="16" ry="20" fill="#fff" stroke="#DB2777" stroke-width="2"/>
                            <circle cx="60" cy="90" r="9" fill="#590D22"/>
                            <circle cx="63" cy="86" r="3" fill="#fff"/>
                            
                            <ellipse cx="140" cy="90" rx="16" ry="20" fill="#fff" stroke="#DB2777" stroke-width="2"/>
                            <circle cx="140" cy="90" r="9" fill="#590D22"/>
                            <circle cx="143" cy="86" r="3" fill="#fff"/>
                        </g>
                        <path d="M 94 115 Q 100 120 106 115" fill="none" stroke="#DB2777" stroke-width="2"/>
                        <path d="M 100 120 L 100 125 M 100 125 Q 90 135 80 130 M 100 125 Q 110 135 120 130" stroke="#374151" stroke-width="2" fill="none" stroke-linecap="round"/>
                    </g>
                    <g id="paws" transform="translate(0, 180)">
                        <g class="transition-transform duration-300 group-hover:translate-y-[-10px]">
                            <path d="M 35 0 Q 25 -30 60 -60 Q 85 -30 75 0 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                            <ellipse cx="55" cy="-25" rx="10" ry="14" fill="#FCE7F3"/>
                        </g>
                        <g class="transition-transform duration-300 group-hover:translate-y-[-10px] delay-75">
                            <path d="M 165 0 Q 175 -30 140 -60 Q 115 -30 125 0 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                            <ellipse cx="145" cy="-25" rx="10" ry="14" fill="#FCE7F3"/>
                        </g>
                    </g>
                </svg>
            </div>
        </div>
    </div>

    {{-- SECTION FITUR --}}
    <div id="fitur" class="bg-gray-50 py-20 relative">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Kenapa Menggunakan Sistem Ini?</h2>
                <div class="w-20 h-1 bg-lab-pink-btn mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Fitur 1 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300">
                    <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center text-lab-pink-btn mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Cek Stok Realtime</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Lihat ketersediaan alat di laboratorium kapan saja dan di mana saja tanpa perlu datang langsung.
                    </p>
                </div>

                {{-- Fitur 2 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Pengajuan Mudah</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Proses peminjaman alat yang praktis. Ajukan lewat web, tunggu persetujuan dosen/admin, dan ambil barang.
                    </p>
                </div>

                {{-- Fitur 3 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition duration-300">
                    <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Persetujuan Cepat</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Notifikasi status peminjaman transparan. Ketahui segera jika permohonan Anda disetujui atau ditolak.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-gray-100 py-10">
        <div class="container mx-auto px-6 text-center">
            <p class="text-gray-400 text-sm font-medium">
                © {{ date('Y') }} Laboratorium PTIK. Dibuat dengan ❤️ dan ☕.
            </p>
        </div>
    </footer>

</body>
</html>