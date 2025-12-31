<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Inventaris Lab PTIK</title>

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
            transition: transform 0.4s ease-out; 
            transform-box: fill-box;
            transform-origin: center bottom;
        }
        #paw-left, #paw-right { transform: translateY(180px); }
        .shy .cat-paw { 
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
        }
        .shy #paw-left { transform: translateY(-70px) translateX(10px) rotate(-10deg); }
        .shy #paw-right { transform: translateY(-70px) translateX(-10px) rotate(10deg); }
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
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</head>
<body class="bg-white min-h-screen font-poppins flex">
    <div class="hidden lg:flex lg:w-1/2 bg-lab-pink relative flex-col justify-center items-center overflow-hidden">
        <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-white rounded-full mix-blend-overlay opacity-40 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply opacity-20 blur-3xl animate-pulse"></div>
        <div class="relative z-10 mb-6 transform scale-110 flex flex-col items-center"> 
            <img src="{{ asset('templates/logo_ptik.png') }}" alt="Logo PTIK" class="w-24 h-auto mb-8 drop-shadow-xl hover:scale-110 transition-transform duration-300">

            <div id="bubble" class="chat-bubble absolute top-20 -right-24 bg-white px-4 py-2 rounded-xl rounded-bl-none shadow-lg border border-lab-pink-btn z-30 w-48 select-none">
                <p id="bubble-text" class="text-xs font-bold text-gray-700 leading-tight text-center">Halo! Daftar dulu yuk ✨</p>
            </div>

            <div class="w-60 h-52 cursor-pointer relative overflow-hidden" id="cat-container" style="border-radius: 0 0 100px 100px;">
                <svg viewBox="0 0 200 180" class="w-full h-full drop-shadow-xl">
                    <g class="cat-head">
                        <path d="M 30 60 L 10 10 L 70 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 28 55 L 18 25 L 55 45 Z" fill="#FCE7F3"/>
                        <path d="M 170 60 L 190 10 L 130 40 Z" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 172 55 L 182 25 L 145 45 Z" fill="#FCE7F3"/>
                        <ellipse cx="100" cy="100" rx="85" ry="75" fill="#fff" stroke="#e5e7eb" stroke-width="2"/>
                        <path d="M 35 155 Q 100 190 165 155 L 165 180 Q 100 215 35 180 Z" fill="#DB2777"/>
                        
                        <g id="eyes">
                            <g transform="translate(60, 90)">
                                <ellipse rx="16" ry="20" fill="#fff" stroke="#DB2777" stroke-width="2"/>
                                <g class="pupil">
                                    <circle cx="0" cy="0" r="9" fill="#590D22"/>
                                    <circle cx="1.5" cy="-2.5" r="3" fill="#fff"/>
                                </g>
                            </g>
                            <g transform="translate(140, 90)">
                                <ellipse rx="16" ry="20" fill="#fff" stroke="#DB2777" stroke-width="2"/>
                                <g class="pupil">
                                    <circle cx="0" cy="0" r="9" fill="#590D22"/>
                                    <circle cx="1.5" cy="-2.5" r="3" fill="#fff"/>
                                </g>
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
        </div>

        <div class="text-center z-10 px-10 select-none">
            <h2 class="text-3xl font-bold text-lab-text mt-2 mb-2 drop-shadow-sm">Bergabunglah Bersama Kami!</h2>
            <p class="text-gray-600 font-medium">Daftarkan akunmu untuk mulai meminjam alat.</p>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white overflow-y-auto">
        <div class="w-full max-w-md">
            
            <div class="text-left mb-6">
                <div class="lg:hidden mb-4 flex justify-center">
                    <img src="{{ asset('templates/logo_ptik.png') }}" alt="Logo PTIK" class="h-16 w-auto drop-shadow-md">
                </div>

                <h1 class="text-3xl font-extrabold text-lab-text">Buat Akun Baru</h1>
                <p class="text-sm text-gray-400 font-medium uppercase tracking-wider mt-1">Sistem Inventaris Lab PTIK</p>
            </div>
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm animate-pulse">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            {{-- Icon Warning --}}
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm leading-5 font-bold text-red-700">
                                Pendaftaran Gagal! Periksa kembali:
                            </h3>
                            <ul class="mt-2 text-xs list-disc list-inside text-red-600 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">NAMA LENGKAP</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full px-4 py-3 bg-gray-50 border-2 {{ $errors->has('name') ? 'border-red-400' : 'border-gray-100 focus:border-lab-pink-btn' }} rounded-xl focus:ring-0 outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                        placeholder="John Doe">
                </div>
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">EMAIL KAMPUS</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="block w-full px-4 py-3 bg-gray-50 border-2 {{ $errors->has('email') ? 'border-red-400' : 'border-gray-100 focus:border-lab-pink-btn' }} rounded-xl focus:ring-0 outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                        placeholder="nim@student.uns.ac.id">
                </div>
                <div class="group relative">
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-bold text-gray-400 ml-1 tracking-wide">NO. WHATSAPP / HP</label>
                        {{-- COUNTER DIGIT HP --}}
                        <span id="contact-counter" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">0/13</span>
                    </div>
                    <input type="number" name="contact" id="contact" value="{{ old('contact') }}" required
                        class="block w-full px-4 py-3 bg-gray-50 border-2 {{ $errors->has('contact') ? 'border-red-400' : 'border-gray-100 focus:border-lab-pink-btn' }} rounded-xl focus:ring-0 outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                        placeholder="08123456789">
                </div>
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">DAFTAR SEBAGAI</label>
                    <div class="relative">
                        <select id="role" name="role" onchange="toggleInputs()"
                            class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 cursor-pointer appearance-none">
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                <div id="input-nim" class="group {{ old('role') == 'dosen' ? 'hidden' : '' }}">
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-bold text-gray-400 ml-1 tracking-wide">NIM</label>
                        {{-- COUNTER DIGIT NIM --}}
                        <span id="nim-counter" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">0/8</span>
                    </div>
                    <input type="text" name="identity_number_mhs" id="identity_number_mhs" value="{{ old('identity_number_mhs') }}" maxlength="8"
                        class="block w-full px-4 py-3 bg-gray-50 border-2 {{ $errors->has('identity_number_mhs') ? 'border-red-400' : 'border-gray-100 focus:border-lab-pink-btn' }} rounded-xl focus:ring-0 outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                        placeholder="M05...">
                </div>
                <div id="input-nip" class="group {{ old('role') == 'dosen' ? '' : 'hidden' }}">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">NIP</label>
                    <input type="text" name="identity_number_dosen" id="identity_number_dosen" value="{{ old('identity_number_dosen') }}"
                        class="block w-full px-4 py-3 bg-gray-50 border-2 {{ $errors->has('identity_number_dosen') ? 'border-red-400' : 'border-gray-100 focus:border-lab-pink-btn' }} rounded-xl focus:ring-0 outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                        placeholder="199...">
                </div>
                <div class="group">
                    <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">PASSWORD</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="block w-full px-4 py-3 pr-12 bg-gray-50 border-2 {{ $errors->has('password') ? 'border-red-400' : 'border-gray-100 focus:border-lab-pink-btn' }} rounded-xl focus:ring-0 outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="••••••••">
                        
                        <button type="button" onclick="togglePassword()" onmousedown="event.preventDefault()"
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
                <button type="submit" id="btn-register"
                    class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-pink-200 transform transition hover:-translate-y-0.5 active:scale-95 duration-200 mt-4">
                    Daftar Sekarang
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-8 text-center pb-4">
                <p class="text-sm text-gray-500 font-medium">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-lab-pink-btn hover:text-pink-700 font-bold transition ml-1 hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    {{-- SCRIPT INTERAKSI --}}
    <script>
        const catContainer = document.getElementById('cat-container');
        const pupils = document.querySelectorAll('.pupil');
        const bubble = document.getElementById('bubble');
        const bubbleText = document.getElementById('bubble-text');
        
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const contactInput = document.getElementById('contact'); 
        const roleInput = document.getElementById('role');
        const nimInput = document.getElementById('identity_number_mhs');
        const nipInput = document.getElementById('identity_number_dosen');
        const passwordInput = document.getElementById('password');

        const contactCounter = document.getElementById('contact-counter');
        const nimCounter = document.getElementById('nim-counter');
        function updateContactUI() {
            let val = contactInput.value;
            if (val.length > 13) {
                contactInput.value = val.slice(0, 13);
                val = contactInput.value;
            }
            contactCounter.innerText = `${val.length}/13`;
            
            if (val.length >= 10 && val.length <= 13) {
                contactCounter.classList.replace('text-gray-400', 'text-green-600');
                contactCounter.classList.replace('bg-gray-100', 'bg-green-100');
            } else {
                contactCounter.classList.replace('text-green-600', 'text-gray-400');
                contactCounter.classList.replace('bg-green-100', 'bg-gray-100');
            }
        }

        function updateNimUI() {
            let val = nimInput.value;
            if (val.length > 8) {
                nimInput.value = val.slice(0, 8);
                val = nimInput.value;
            }
            nimCounter.innerText = `${val.length}/8`;
            
            if (val.length === 8) {
                nimCounter.classList.replace('text-gray-400', 'text-green-600');
                nimCounter.classList.replace('bg-gray-100', 'bg-green-100');
            } else {
                nimCounter.classList.replace('text-green-600', 'text-gray-400');
                nimCounter.classList.replace('bg-green-100', 'bg-gray-100');
            }
        }

        contactInput.addEventListener('input', updateContactUI);
        nimInput.addEventListener('input', updateNimUI);
        let bubbleTimeout;
        const messages = ["Miaw! 😽", "Isi yang lengkap ya!", "Semangat daftarnya! 🔥", "Aku siap menjaga lab! 🛡️"];

        function say(text) {
            clearTimeout(bubbleTimeout);
            bubbleText.innerText = text;
            bubble.classList.add('visible');
            bubbleTimeout = setTimeout(() => bubble.classList.remove('visible'), 3000);
        }
        nameInput.addEventListener('focus', () => say("Siapa namamu? 🤔"));
        nameInput.addEventListener('input', () => {
            catContainer.classList.add('typing');
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => catContainer.classList.remove('typing'), 500);
        });

        emailInput.addEventListener('focus', () => say("Email kampus ya! 📧"));
        contactInput.addEventListener('focus', () => say("Nomor HP aktif ya! 📱"));
        roleInput.addEventListener('focus', () => say("Pilih peranmu! 🎭"));
        nimInput.addEventListener('focus', () => say("NIM kamu berapa? 🆔"));
        nipInput.addEventListener('focus', () => say("NIP Bapak/Ibu? 🆔"));
        
        document.getElementById('btn-register').addEventListener('mouseenter', () => say("Gas Daftar! 🚀"));

        catContainer.addEventListener('click', () => {
            const randomMsg = messages[Math.floor(Math.random() * messages.length)];
            say(randomMsg);
            catContainer.style.transform = "scale(1.15)";
            setTimeout(() => catContainer.style.transform = "scale(1.1)", 150);
        });

        function toggleInputs() {
            const role = roleInput.value;
            const inputNim = document.getElementById('input-nim');
            const inputNip = document.getElementById('input-nip');

            inputNim.classList.add('hidden');
            inputNip.classList.add('hidden');

            if (role === 'mahasiswa') {
                inputNim.classList.remove('hidden');
                say("Halo Mahasiswa! 👋");
            } else if (role === 'dosen') {
                inputNip.classList.remove('hidden');
                say("Halo Pak/Bu Dosen! 🎓");
            }
        }
        const eyeRadius = 8;
        document.addEventListener('mousemove', (e) => {
            if (catContainer.classList.contains('shy')) return;
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

        let typingTimer;
        passwordInput.addEventListener('focus', () => {
            catContainer.classList.add('shy');
            say("Ssstt.. Rahasia! 🙈");
        });
        
        passwordInput.addEventListener('blur', () => {
            catContainer.classList.remove('shy');
            say("Oke, aman! 👍");
        });

        function togglePassword() {
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
            passwordInput.focus();
            if (!catContainer.classList.contains('shy')) {
                catContainer.classList.add('shy');
            }
        }
        updateContactUI();
        updateNimUI();
        toggleInputs(); 
    </script>
</body>
</html>