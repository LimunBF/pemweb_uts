<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Lab PTIK</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('templates/logo.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Palet Warna Sesuai Skrip Sebelumnya
                        'lab-pink': '#FCE7F3',       // Pink Muda (Background Header & Hover Sidebar)
                        'lab-pink-dark': '#FF91A4',  // Pink Sedang
                        'lab-text': '#590D22',       // Merah Gelap (Teks Judul)
                        'lab-pink-btn': '#DB2777',   // Pink Tua (Tombol Utama)
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'], // Font Poppins
                    }
                }
            }
        }
    </script>
    <style>
        /* Import Font Poppins */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }

        /* --- ANIMASI BADAN & KEPALA --- */
        .cat-head { transition: transform 0.3s ease-out; }
        
        /* --- ANIMASI TANGAN (PAWS) --- */
        .cat-paw {
            transition: transform 0.4s ease-out; 
            transform-box: fill-box;
            transform-origin: center bottom;
        }
        
        /* Transisi Saat Malu (Saat Naik) */
        .shy .cat-paw {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        /* Posisi Awal Tangan (Sembunyi di bawah) */
        #paw-left, #paw-right { transform: translateY(120px); }

        /* Posisi Saat Malu (Naik & Nutup Mata) */
        .shy #paw-left {
            transform: translateY(-70px) translateX(10px) rotate(-10deg);
        }
        .shy #paw-right {
            transform: translateY(-70px) translateX(-10px) rotate(10deg);
        }

        /* --- MATA --- */
        .pupil { transition: transform 0.1s ease-out; }
        .typing .pupil { transition: transform 0.05s linear; }

        /* --- BUBBLE CHAT --- */
        .chat-bubble {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            opacity: 0;
            transform: translateY(10px) scale(0.8);
            pointer-events: none;
        }
        .chat-bubble.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center relative overflow-hidden font-poppins">

    {{-- Background Decor --}}
    <div class="absolute inset-0 overflow-hidden -z-10">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-pulse"></div>
    </div>

    {{-- Container Utama (Ditambah mt-24 agar posisi turun ke bawah) --}}
    <div class="w-full max-w-sm flex flex-col items-center relative mt-24">
        
        {{-- CHAT BUBBLE --}}
        <div id="bubble" class="chat-bubble absolute -top-40 -right-16 bg-white px-5 py-3 rounded-2xl rounded-bl-none shadow-xl border-2 border-lab-pink-btn z-30 max-w-[200px]">
            <p id="bubble-text" class="text-xs font-bold text-gray-700 leading-tight">Halo! Masuk dulu yuk ✨</p>
        </div>

        {{-- SVG KUCING --}}
        <div class="w-60 h-52 absolute -top-40 z-0 cursor-pointer" id="cat-container">
            <svg viewBox="0 0 200 180" class="w-full h-full drop-shadow-2xl overflow-visible">
                
                <g class="cat-head">
                    <!-- Telinga & Kepala -->
                    <path d="M 30 60 L 10 10 L 70 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                    <path d="M 28 55 L 18 25 L 55 45 Z" fill="#FCE7F3"/> <!-- Pink Muda -->
                    <path d="M 170 60 L 190 10 L 130 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                    <path d="M 172 55 L 182 25 L 145 45 Z" fill="#FCE7F3"/> <!-- Pink Muda -->

                    <ellipse cx="100" cy="100" rx="85" ry="75" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                    
                    <!-- Baju Kucing (Pink Tua / Button Color) -->
                    <path d="M 35 155 Q 100 190 165 155 L 165 170 Q 100 205 35 170 Z" fill="#DB2777"/>
                    
                    <g id="eyes">
                        <g transform="translate(60, 90)">
                            <ellipse rx="16" ry="20" fill="#fff" stroke="#DB2777" stroke-width="2"/>
                            <circle class="pupil" cx="0" cy="0" r="9" fill="#590D22"/>
                            <circle cx="4" cy="-5" r="3" fill="#fff"/>
                        </g>
                        <g transform="translate(140, 90)">
                            <ellipse rx="16" ry="20" fill="#fff" stroke="#DB2777" stroke-width="2"/>
                            <circle class="pupil" cx="0" cy="0" r="9" fill="#590D22"/>
                            <circle cx="4" cy="-5" r="3" fill="#fff"/>
                        </g>
                    </g>

                    <path d="M 94 115 Q 100 120 106 115" fill="none" stroke="#DB2777" stroke-width="2"/>
                    <path d="M 100 120 L 100 125 M 100 125 Q 90 135 80 130 M 100 125 Q 110 135 120 130" stroke="#374151" stroke-width="2" fill="none" stroke-linecap="round"/>
                </g>

                <g id="paws" transform="translate(0, 180)">
                    <g id="paw-left" class="cat-paw">
                        <path d="M 35 0 Q 25 -30 60 -60 Q 85 -30 75 0 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <ellipse cx="55" cy="-25" rx="10" ry="14" fill="#FCE7F3"/>
                    </g>
                    <g id="paw-right" class="cat-paw">
                        <path d="M 165 0 Q 175 -30 140 -60 Q 115 -30 125 0 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <ellipse cx="145" cy="-25" rx="10" ry="14" fill="#FCE7F3"/>
                    </g>
                </g>
            </svg>
        </div>

        {{-- LOGIN CARD --}}
        <div class="bg-white w-full rounded-3xl shadow-xl relative z-10 px-8 pt-12 pb-8 border-t-8 border-lab-pink-btn">
            
            <div class="text-center mb-6">
                <h1 class="text-2xl font-extrabold text-lab-text">Welcome Back!</h1>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Sistem Inventaris Lab PTIK</p>
            </div>

            {{-- Pesan Error --}}
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-200 text-red-600 px-4 py-2 rounded-lg text-sm text-center font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-600 px-4 py-2 rounded-lg text-sm text-center font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">EMAIL</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                        placeholder="mahasiswa@email.com">
                </div>

                {{-- Password dengan Toggle --}}
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">PASSWORD</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="block w-full px-4 py-3 pr-12 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="••••••••">
                        
                        <!-- Tombol Mata -->
                        <button type="button" onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-lab-pink-btn transition focus:outline-none">
                            <svg id="eye-open" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-closed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Tombol Login --}}
                <button type="submit" id="btn-login"
                    class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-pink-200 transform transition hover:-translate-y-0.5 active:scale-95 duration-200 flex justify-center items-center gap-2">
                    Masuk Sekarang
                </button>
            </form>

            {{-- FOOTER REGISTER --}}
            <div class="mt-8 pt-6 border-t border-gray-100 text-center space-y-3">
                <p class="text-xs text-gray-500 font-semibold">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-lab-pink-btn hover:text-pink-700 font-extrabold transition ml-1 hover:underline">
                        Daftar Anggota Baru
                    </a>
                </p>
                <a href="https://wa.me/6285175405338?text=Halo+Admin+saya+lupa+password+akun+lab" target="_blank" ...>
                    Lupa Password? Hubungi Admin Lab
                </a>
            </div>
        </div>
    </div>

    {{-- SCRIPT LOGIC (KUCING + PASSWORD) --}}
    <script>
        const catContainer = document.getElementById('cat-container');
        const pupils = document.querySelectorAll('.pupil');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const bubble = document.getElementById('bubble');
        const bubbleText = document.getElementById('bubble-text');
        
        let bubbleTimeout;
        function say(text) {
            clearTimeout(bubbleTimeout);
            bubbleText.innerText = text;
            bubble.classList.add('visible');
            bubbleTimeout = setTimeout(() => {
                bubble.classList.remove('visible');
            }, 3000); 
        }

        let isTyping = false;
        let typingTimer;
        const eyeRadius = 8; 

        // Fungsi Gerak Mata
        function moveEyes(xOffset, yOffset) {
            pupils.forEach(pupil => {
                const limitX = Math.max(-eyeRadius, Math.min(xOffset, eyeRadius));
                const limitY = Math.max(-eyeRadius, Math.min(yOffset, eyeRadius));
                pupil.style.transform = `translate(${limitX}px, ${limitY}px)`;
            });
        }

        document.addEventListener('mousemove', (e) => {
            if (catContainer.classList.contains('shy') || isTyping) return;

            pupils.forEach(pupil => {
                const rect = pupil.getBoundingClientRect();
                const x = rect.left + rect.width / 2;
                const y = rect.top + rect.height / 2;
                
                const angle = Math.atan2(e.clientY - y, e.clientX - x);
                const distance = Math.min(eyeRadius, Math.hypot(e.clientX - x, e.clientY - y) / 6);

                const moveX = Math.cos(angle) * distance;
                const moveY = Math.sin(angle) * distance;

                pupil.style.transform = `translate(${moveX}px, ${moveY}px)`;
            });
        });

        emailInput.addEventListener('input', (e) => {
            isTyping = true;
            catContainer.classList.add('typing');
            const valLength = e.target.value.length;
            const xPos = (valLength * 0.8) - 10; 
            moveEyes(xPos, 5); 
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                isTyping = false;
                catContainer.classList.remove('typing');
            }, 500);
        });

        emailInput.addEventListener('focus', () => say("Cek ejaannya ya! 🧐"));

        // LOGIKA PASSWORD (TUTUP MATA / TANGAN)
        passwordInput.addEventListener('focus', () => {
            catContainer.classList.add('shy'); // Tangan naik
            say("Jangan kasih tau siapa-siapa! 🙈");
        });
        
        passwordInput.addEventListener('blur', () => {
            catContainer.classList.remove('shy'); // Tangan turun
            say("Udah aman? Sip! 👍");
        });

        document.getElementById('forgot-link').addEventListener('mouseenter', () => say("Waduh, kok bisa lupa? 🙀"));
        document.getElementById('btn-login').addEventListener('mouseenter', () => say("Gass Masuk! 🚀"));

        catContainer.addEventListener('click', () => {
            say("Meow! 😺");
            catContainer.style.transform = "scale(1.05)";
            setTimeout(() => catContainer.style.transform = "scale(1)", 150);
        });

        // Toggle Password Logic
        function togglePassword() {
            var eyeOpen = document.getElementById("eye-open");
            var eyeClosed = document.getElementById("eye-closed");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeOpen.classList.remove("hidden");
                eyeClosed.classList.add("hidden");
                // Saat intip password, kucing kaget (opsional: buka tangan)
                catContainer.classList.remove('shy'); 
                say("Hayo ngintip! 👀");
            } else {
                passwordInput.type = "password";
                eyeOpen.classList.add("hidden");
                eyeClosed.classList.remove("hidden");
                // Tutup mata lagi
                catContainer.classList.add('shy');
            }
        }
    </script>
</body>
</html>
