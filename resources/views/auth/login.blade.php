<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Lab PTIK</title>
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
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }

        .cat-head { transition: transform 0.3s ease-out; }
        
        .cat-paw {
            transition: transform 0.4s ease-out, opacity 0.3s ease; 
            transform-box: fill-box;
            transform-origin: center bottom;
            opacity: 0; 
        }
        
        #paw-left, #paw-right { 
            transform: translateY(180px); 
        }

        .shy .cat-paw {
            opacity: 1; 
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.1s ease;
        }
        
        .shy #paw-left {
            transform: translateY(-70px) translateX(10px) rotate(-10deg);
        }
        .shy #paw-right {
            transform: translateY(-70px) translateX(-10px) rotate(10deg);
        }

        .pupil { transition: transform 0.1s ease-out; }
        .typing .pupil { transition: transform 0.05s linear; }

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
        
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
    </style>
</head>
<body class="font-poppins h-screen flex overflow-hidden bg-white">

    <div class="hidden lg:flex w-5/12 bg-lab-pink relative flex-col items-center justify-center overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-white rounded-full mix-blend-overlay opacity-50 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply opacity-20 blur-3xl animate-pulse"></div>

        <div class="relative z-10 flex flex-col items-center">
            <img src="{{ asset('templates/logo_ptik.png') }}" alt="Logo PTIK" class="w-20 h-auto mb-6 drop-shadow-xl hover:scale-110 transition-transform duration-300">
            <div id="bubble" class="chat-bubble absolute top-16 -right-24 bg-white px-4 py-2 rounded-xl rounded-bl-none shadow-lg border-2 border-lab-pink-btn z-30 w-48 text-center">
                <p id="bubble-text" class="text-xs font-bold text-gray-700 leading-tight">Halo! Masuk dulu yuk ✨</p>
            </div>
            <div class="w-64 h-64 cursor-pointer drop-shadow-2xl" id="cat-container">
                <svg viewBox="0 0 200 180" class="w-full h-full overflow-visible">
                    <g class="cat-head">
                        <path d="M 30 60 L 10 10 L 70 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 28 55 L 18 25 L 55 45 Z" fill="#FCE7F3"/>
                        <path d="M 170 60 L 190 10 L 130 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 172 55 L 182 25 L 145 45 Z" fill="#FCE7F3"/>
                        <ellipse cx="100" cy="100" rx="85" ry="75" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
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
            
            <div class="mt-4 text-center">
                <h2 class="text-2xl font-bold text-lab-text">Sistem Inventaris</h2>
                <p class="text-gray-600 text-sm">Laboratorium PTIK</p>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-7/12 flex items-center justify-center p-8 bg-white relative overflow-y-auto">
        <div class="lg:hidden absolute top-0 left-0 w-full bg-lab-pink h-32 rounded-b-[3rem] -z-10"></div>
        <div class="w-full max-w-md space-y-8 animate-fade-in-up bg-white p-8 rounded-3xl shadow-xl lg:shadow-none border lg:border-none border-gray-100">
            <div class="flex flex-col items-center lg:items-start mb-8">
                <div class="lg:hidden mb-4">
                    <img src="{{ asset('templates/logo_ptik.png') }}" alt="Logo PTIK" class="h-16 w-auto drop-shadow-md">
                </div>
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-extrabold text-gray-900">Welcome Back! 👋</h2>
                    <p class="mt-2 text-sm text-gray-500 font-medium">Silakan masuk menggunakan akun kampus Anda.</p>
                </div>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg text-sm flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $errors->first() }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg text-sm flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div class="group">
                        <label for="email" class="block text-xs font-bold text-gray-400 mb-1 tracking-wide group-focus-within:text-lab-pink-btn transition-colors">EMAIL KAMPUS</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                                class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent transition sm:text-sm bg-gray-50 focus:bg-white font-medium text-gray-700" 
                                placeholder="nama@student.uns.ac.id">
                        </div>
                    </div>
                    <div class="group">
                        <label for="password" class="block text-xs font-bold text-gray-400 mb-1 tracking-wide group-focus-within:text-lab-pink-btn transition-colors">PASSWORD</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="appearance-none block w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent transition sm:text-sm bg-gray-50 focus:bg-white font-medium text-gray-700" 
                                placeholder="••••••••">
                            <button type="button" onclick="togglePassword()" onmousedown="event.preventDefault()"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-lab-pink-btn transition focus:outline-none cursor-pointer">
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
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-lab-pink-btn focus:ring-pink-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">Ingat Saya</label>
                    </div>
                    <div class="text-sm">
                        <a href="https://wa.me/6285175405338?text=Halo+Admin+saya+lupa+password+akun+lab" target="_blank" 
                            class="font-bold text-lab-pink-btn hover:text-pink-800 transition">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" id="btn-login"
                        class="group relative w-full flex justify-center py-3.5 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-lab-pink-btn hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition duration-300 shadow-lg hover:shadow-pink-200 transform hover:-translate-y-0.5 active:scale-95">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-pink-300 group-hover:text-pink-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </span>
                        Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-extrabold text-lab-pink-btn hover:text-pink-800 transition">Daftar disini</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        const catContainer = document.getElementById('cat-container');
        const pupils = document.querySelectorAll('.pupil');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const bubble = document.getElementById('bubble');
        const bubbleText = document.getElementById('bubble-text');
        
        let bubbleTimeout;
        const eyeRadius = 8; 
        let isTyping = false;
        let typingTimer;

        function say(text) {
            clearTimeout(bubbleTimeout);
            bubbleText.innerText = text;
            bubble.classList.add('visible');
            bubbleTimeout = setTimeout(() => {
                bubble.classList.remove('visible');
            }, 3000); 
        }
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
            const valLength = e.target.value.length;
            const xPos = (valLength * 0.8) - 10; 
            moveEyes(xPos, 5); 
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                isTyping = false;
            }, 500);
        });

        emailInput.addEventListener('focus', () => say("Cek ejaannya ya! 🧐"));
        passwordInput.addEventListener('focus', () => {
            catContainer.classList.add('shy'); 
            say("Jangan kasih tau siapa-siapa! 🙈");
        });
        
        passwordInput.addEventListener('blur', () => {
            catContainer.classList.remove('shy'); 
            say("Udah aman? Sip! 👍");
        });

        document.getElementById('btn-login').addEventListener('mouseenter', () => say("Gass Masuk! 🚀"));
        catContainer.addEventListener('click', () => {
            say("Meow! 😺");
            catContainer.style.transform = "scale(1.05)";
            setTimeout(() => catContainer.style.transform = "scale(1)", 150);
        });

        // Toggle Password Visibility
        function togglePassword() {
            var eyeOpen = document.getElementById("eye-open");
            var eyeClosed = document.getElementById("eye-closed");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeOpen.classList.remove("hidden");
                eyeClosed.classList.add("hidden");
                say("Hayo ngintip! 👀"); 
            } else {
                passwordInput.type = "password";
                eyeOpen.classList.add("hidden");
                eyeClosed.classList.remove("hidden");
            }
            passwordInput.focus();
        }
    </script>
</body>
</html>