<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Login - Laboratorium PTIK</title>
=======
    <title>Login - Sistem Inventaris Lab PTIK</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

>>>>>>> feature/login
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
<<<<<<< HEAD
                        'lab-pink': '#db2777',
                        'lab-dark': '#831843',
=======
                        'lab-pink': '#FFC0CB',       
                        'lab-pink-dark': '#FF91A4', 
                        'lab-pink-btn': '#DB2777',   
                        'lab-text': '#881337',       
>>>>>>> feature/login
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* --- ANIMASI BADAN & KEPALA --- */
        .cat-head { transition: transform 0.3s ease-out; }
        
<<<<<<< HEAD
        /* --- ANIMASI TANGAN (PAWS) --- */
        /* 1. Transisi Default (Saat Turun/Sembunyi) - Pakai ease-out biar mulus ke bawah */
        .cat-paw {
            transition: transform 0.4s ease-out; 
            transform-box: fill-box;
            transform-origin: center bottom;
        }
        
        /* 2. Transisi Saat Malu (Saat Naik) - Pakai cubic-bezier biar membal lucu */
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
<body class="bg-pink-50 min-h-screen flex items-center justify-center relative overflow-hidden">

    {{-- Background Decor --}}
    <div class="absolute inset-0 overflow-hidden -z-10">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-pulse"></div>
    </div>

    <div class="w-full max-w-sm flex flex-col items-center relative">
        
        {{-- CHAT BUBBLE --}}
        <div id="bubble" class="chat-bubble absolute -top-40 -right-16 bg-white px-5 py-3 rounded-2xl rounded-bl-none shadow-xl border-2 border-lab-pink z-30 max-w-[200px]">
            <p id="bubble-text" class="text-xs font-bold text-gray-700 leading-tight">Halo! Masuk dulu yuk ✨</p>
        </div>

        {{-- SVG KUCING --}}
        <div class="w-60 h-52 absolute -top-40 z-0 cursor-pointer" id="cat-container">
            <svg viewBox="0 0 200 180" class="w-full h-full drop-shadow-2xl overflow-visible">
                
                <g class="cat-head">
                    <path d="M 30 60 L 10 10 L 70 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                    <path d="M 28 55 L 18 25 L 55 45 Z" fill="#fbcfe8"/> 
                    <path d="M 170 60 L 190 10 L 130 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                    <path d="M 172 55 L 182 25 L 145 45 Z" fill="#fbcfe8"/>

                    <ellipse cx="100" cy="100" rx="85" ry="75" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                    
                    <path d="M 35 155 Q 100 190 165 155 L 165 170 Q 100 205 35 170 Z" fill="#db2777"/>
                    
                    <g id="eyes">
                        <g transform="translate(60, 90)">
                            <ellipse rx="16" ry="20" fill="#fff" stroke="#db2777" stroke-width="2"/>
                            <circle class="pupil" cx="0" cy="0" r="9" fill="#1f2937"/>
                            <circle cx="4" cy="-5" r="3" fill="#fff"/>
                        </g>
                        <g transform="translate(140, 90)">
                            <ellipse rx="16" ry="20" fill="#fff" stroke="#db2777" stroke-width="2"/>
                            <circle class="pupil" cx="0" cy="0" r="9" fill="#1f2937"/>
                            <circle cx="4" cy="-5" r="3" fill="#fff"/>
                        </g>
                    </g>
=======
        <!-- HEADER -->
        <div class="bg-lab-pink p-8 text-center relative">
            <div class="mx-auto bg-white w-20 h-20 rounded-full flex items-center justify-center text-lab-pink-btn mb-4 shadow-md ring-4 ring-pink-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-lab-text tracking-wide">Lab PTIK</h2>
            <p class="text-gray-700 text-sm mt-2 font-medium">Silakan Login</p>
        </div>

        <!-- FORMULIR -->
        <div class="p-8 pt-8">
            
            {{-- Pesan Sukses Register --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Pesan Error Login --}}
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm shadow-sm flex items-start">
                    <div>
                        <p class="font-bold">Gagal Masuk</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif
>>>>>>> feature/login

                    <path d="M 94 115 Q 100 120 106 115" fill="none" stroke="#db2777" stroke-width="2"/>
                    <path d="M 100 120 L 100 125 M 100 125 Q 90 135 80 130 M 100 125 Q 110 135 120 130" stroke="#374151" stroke-width="2" fill="none" stroke-linecap="round"/>
                </g>

<<<<<<< HEAD
                <g id="paws" transform="translate(0, 180)">
                    <g id="paw-left" class="cat-paw">
                        <path d="M 35 0 Q 25 -30 60 -60 Q 85 -30 75 0 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <ellipse cx="55" cy="-25" rx="10" ry="14" fill="#fbcfe8"/>
                    </g>
                    <g id="paw-right" class="cat-paw">
                        <path d="M 165 0 Q 175 -30 140 -60 Q 115 -30 125 0 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <ellipse cx="145" cy="-25" rx="10" ry="14" fill="#fbcfe8"/>
                    </g>
                </g>
            </svg>
        </div>

        {{-- LOGIN CARD --}}
        <div class="bg-white w-full rounded-3xl shadow-xl relative z-10 px-8 pt-12 pb-8 border-t-8 border-lab-pink">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-extrabold text-gray-800">Welcome Back!</h1>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Laboratorium PTIK</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1">EMAIL</label>
                    <input id="email" type="email" name="email" required autofocus
                        class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink outline-none transition font-bold text-gray-700 placeholder-gray-300"
                        placeholder="mahasiswa@email.com">
                </div>

                {{-- Password --}}
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1">PASSWORD</label>
                    <input id="password" type="password" name="password" required
                        class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink outline-none transition font-bold text-gray-700 placeholder-gray-300"
                        placeholder="••••••••">
                </div>

                {{-- Tombol Login --}}
                <button type="submit" id="btn-login"
                    class="w-full bg-lab-pink hover:bg-pink-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-pink-200 transform transition hover:-translate-y-0.5 active:scale-95 duration-200 flex justify-center items-center gap-2">
=======
                <!-- Input Email -->
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" id="email" required autofocus
                        class="w-full pl-4 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 transition-all bg-gray-50 focus:bg-white"
                        placeholder="email@contoh.com">
                </div>

                <!-- Input Password (DENGAN FITUR LIHAT PASSWORD) -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-gray-700 text-sm font-bold">Kata Sandi</label>
                    </div>
                    
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 transition-all bg-gray-50 focus:bg-white"
                            placeholder="••••••••">
                        
                        <!-- Tombol Mata (Toggle Password) -->
                        <button type="button" onclick="togglePassword()" 
                            class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-500 hover:text-lab-pink-btn focus:outline-none">
                            <!-- Icon Mata Terbuka (Default Hidden) -->
                            <svg id="eye-open" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Icon Mata Tertutup (Default Visible) -->
                            <svg id="eye-closed" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
>>>>>>> feature/login
                    Masuk Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>

                <div class="text-center">
                    <a href="#" id="forgot-link" class="text-xs font-bold text-gray-400 hover:text-lab-pink transition">Lupa password?</a>
                </div>
            </form>
        </div>
<<<<<<< HEAD
    </div>

    {{-- SCRIPT LOGIC --}}
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
            catContainer.classList.add('shy'); // Tangan naik (bouncy)
            say("Jangan kasih tau siapa-siapa! 🙈");
        });
        
        passwordInput.addEventListener('blur', () => {
            catContainer.classList.remove('shy'); // Tangan turun (smooth)
            say("Udah aman? Sip! 👍");
        });

        document.getElementById('forgot-link').addEventListener('mouseenter', () => say("Waduh, kok bisa lupa? 🙀"));
        document.getElementById('btn-login').addEventListener('mouseenter', () => say("Gass Masuk! 🚀"));

        catContainer.addEventListener('click', () => {
            say("Meow! 😺");
            catContainer.style.transform = "scale(1.05)";
            setTimeout(() => catContainer.style.transform = "scale(1)", 150);
        });

    </script>
=======
        
        <!-- footer -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center space-y-2">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-lab-pink-btn hover:text-pink-800 font-bold transition ml-1 hover:underline">
                    Daftar Akun Baru
                </a>
            </p>
            <p class="text-xs text-gray-400 mt-2">
                Lupa password? Hubungi 
                <a href="#" class="text-gray-500 hover:text-lab-pink-btn font-semibold transition hover:underline">
                    Administrator
                </a>
            </p>
        </div>

    </div>

    <!-- Script JavaScript untuk Toggle Password -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeOpen = document.getElementById("eye-open");
            var eyeClosed = document.getElementById("eye-closed");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeOpen.classList.remove("hidden");
                eyeClosed.classList.add("hidden");
            } else {
                passwordInput.type = "password";
                eyeOpen.classList.add("hidden");
                eyeClosed.classList.remove("hidden");
            }
        }
    </script>

>>>>>>> feature/login
</body>
</html>