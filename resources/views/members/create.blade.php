@extends('layouts.app')

@section('content')
{{-- Load SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Import Font & Custom Styles --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    /* --- Definisi Warna Custom (Sesuai request) --- */
    :root {
        --lab-pink: #FCE7F3;
        --lab-pink-dark: #FF91A4;
        --lab-text: #590D22;
        --lab-pink-btn: #DB2777;
    }

    .font-poppins { font-family: 'Poppins', sans-serif; }
    .text-lab-text { color: var(--lab-text); }
    .text-lab-pink-btn { color: var(--lab-pink-btn); }
    .bg-lab-pink { background-color: var(--lab-pink); }
    .bg-lab-pink-btn { background-color: var(--lab-pink-btn); }
    .border-lab-pink-btn { border-color: var(--lab-pink-btn); }

    /* --- ANIMASI KUCING --- */
    .cat-head { transition: transform 0.3s ease-out; }
    .cat-paw {
        transition: transform 0.4s ease-out; 
        transform-box: fill-box;
        transform-origin: center bottom;
    }
    
    /* POSISI AWAL TANGAN (Sembunyi) */
    #paw-left, #paw-right { transform: translateY(180px); }

    /* Transisi Saat Malu */
    .shy .cat-paw { 
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); 
    }
    
    /* Posisi Tangan Menutup Mata (Shy) */
    .shy #paw-left { transform: translateY(-70px) translateX(10px) rotate(-10deg); }
    .shy #paw-right { transform: translateY(-70px) translateX(-10px) rotate(10deg); }

    /* Mata & Pupil */
    .pupil { transition: transform 0.1s ease-out; }
    .typing .pupil { transition: transform 0.05s linear; }

    /* Chat Bubble */
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
    
    /* Hilangkan spinner input number */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    /* Animasi Fade In Container */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-element {
        opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<div class="w-full font-poppins">
    
    {{-- Tombol Kembali --}}
    <div class="animate-element mb-6" style="animation-delay: 0.05s;">
        <a href="{{ route('members.index') }}" class="inline-flex items-center text-gray-500 hover:text-lab-pink-btn transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Anggota
        </a>
    </div>

    {{-- Main Card Container (Split Layout) --}}
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col lg:flex-row animate-element border border-gray-100" style="animation-delay: 0.1s;">
        
        {{-- BAGIAN KIRI: Animasi Kucing (Visual) --}}
        <div class="lg:w-5/12 bg-lab-pink relative flex flex-col justify-center items-center overflow-hidden p-10 min-h-[300px] lg:min-h-full">
            {{-- Background Effects --}}
            <div class="absolute top-[-10%] right-[-10%] w-64 h-64 bg-white rounded-full mix-blend-overlay opacity-40 blur-3xl animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-64 h-64 bg-pink-400 rounded-full mix-blend-multiply opacity-20 blur-3xl animate-pulse"></div>

            <div class="relative z-10 transform scale-100 lg:scale-110"> 
                {{-- Chat Bubble --}}
                <div id="bubble" class="chat-bubble absolute -top-16 -right-24 bg-white px-4 py-2 rounded-xl rounded-bl-none shadow-lg border border-lab-pink-btn z-30 w-48 select-none">
                    <p id="bubble-text" class="text-xs font-bold text-gray-700 leading-tight text-center">Halo Admin! Tambah anggota yuk ✨</p>
                </div>

                {{-- Cat SVG Container --}}
                <div class="w-52 h-48 cursor-pointer relative overflow-hidden" id="cat-container" style="border-radius: 0 0 100px 100px;">
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

            <div class="text-center z-10 px-6 mt-6 select-none">
                <h2 class="text-2xl font-bold text-lab-text mb-1">Tambah Anggota</h2>
                <p class="text-gray-600 text-sm font-medium">Lengkapi data Mahasiswa atau Dosen.</p>
            </div>
        </div>

        {{-- BAGIAN KANAN: Form Input --}}
        <div class="lg:w-7/12 p-8 lg:p-10 bg-white">
            <div class="max-w-md mx-auto">
                <form id="createMemberForm" action="{{ route('members.store') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    {{-- Role Selection --}}
                    <div class="group">
                        <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">ROLE ANGGOTA</label>
                        <div class="relative">
                            <select id="role" name="role" onchange="toggleInputs()"
                                class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 cursor-pointer appearance-none hover:border-pink-200">
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="group">
                        <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">NAMA LENGKAP</label>
                        <input type="text" name="name" id="name" required
                            class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="Contoh: Budi Santoso">
                    </div>

                    {{-- Input NIM (Mahasiswa) --}}
                    <div id="input-nim" class="group">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-bold text-gray-400 ml-1 tracking-wide">NIM</label>
                            <span id="nim-counter" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">0/8</span>
                        </div>
                        <input type="text" name="identity_number_mhs" id="identity_number_mhs" maxlength="8"
                            class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="M05...">
                    </div>

                    {{-- Input NIP (Dosen) --}}
                    <div id="input-nip" class="group hidden">
                        <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">NIP</label>
                        <input type="text" name="identity_number_dosen" id="identity_number_dosen"
                            class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="199...">
                    </div>

                    {{-- Email --}}
                    <div class="group">
                        <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">EMAIL KAMPUS</label>
                        <input type="email" name="email" id="email" required
                            class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="nama@staff.uns.ac.id">
                    </div>

                    {{-- Contact --}}
                    <div class="group">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-xs font-bold text-gray-400 ml-1 tracking-wide">NO. WHATSAPP</label>
                            <span id="contact-counter" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">0/13</span>
                        </div>
                        <input type="number" name="contact" id="contact"
                            class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                            placeholder="08123456789">
                    </div>

                    {{-- Password Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Password --}}
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">PASSWORD</label>
                            <input type="password" name="password" id="password" required
                                class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                                placeholder="••••••••">
                        </div>
                        {{-- Confirm Password --}}
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-400 mb-1 ml-1 tracking-wide">ULANGI PASSWORD</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="block w-full px-4 py-3 bg-gray-50 border-2 border-gray-100 rounded-xl focus:ring-0 focus:border-lab-pink-btn outline-none transition font-semibold text-gray-700 placeholder-gray-300"
                                placeholder="••••••••">
                        </div>
                    </div>
                    
                    {{-- Show Password Toggle --}}
                    <div class="flex items-center justify-end">
                        <button type="button" onclick="toggleAllPasswords()" class="text-xs text-gray-400 hover:text-lab-pink-btn font-semibold flex items-center focus:outline-none transition">
                            <svg id="eye-icon-global" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Lihat Password
                        </button>
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" id="btn-submit"
                        class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-pink-200 transform transition hover:-translate-y-0.5 active:scale-95 duration-200 mt-6 flex justify-center items-center">
                        <span id="btn-text">Simpan Anggota</span>
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    /* --- LOGIKA INTERAKSI & ANIMASI --- */
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
    const passInput = document.getElementById('password');
    const confInput = document.getElementById('password_confirmation');
    
    // Counters
    const contactCounter = document.getElementById('contact-counter');
    const nimCounter = document.getElementById('nim-counter');

    // --- 1. COUNTER LOGIC ---
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

    // --- 2. CHAT BUBBLE ---
    let bubbleTimeout;
    function say(text) {
        clearTimeout(bubbleTimeout);
        bubbleText.innerText = text;
        bubble.classList.add('visible');
        bubbleTimeout = setTimeout(() => bubble.classList.remove('visible'), 3000);
    }

    // --- 3. INTERAKSI INPUT ---
    let typingTimer;
    function setTyping() {
        catContainer.classList.add('typing');
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => catContainer.classList.remove('typing'), 500);
    }

    nameInput.addEventListener('focus', () => say("Siapa namanya? 🤔"));
    nameInput.addEventListener('input', setTyping);
    
    emailInput.addEventListener('focus', () => say("Email kampus ya! 📧"));
    contactInput.addEventListener('focus', () => say("Nomor WA aktif! 📱"));
    roleInput.addEventListener('focus', () => say("Dosen atau Mahasiswa? 🎭"));
    nimInput.addEventListener('focus', () => say("NIM nya berapa? 🆔"));
    nipInput.addEventListener('focus', () => say("NIP nya berapa? 🆔"));
    
    document.getElementById('btn-submit').addEventListener('mouseenter', () => say("Simpan Data? 💾"));

    catContainer.addEventListener('click', () => {
        const msgs = ["Miaw! 😽", "Admin semangat!", "Datanya udah bener?", "Aku jagain Lab! 🛡️"];
        say(msgs[Math.floor(Math.random() * msgs.length)]);
    });

    // --- 4. TOGGLE ROLE & INPUTS ---
    function toggleInputs() {
        const role = roleInput.value;
        const divNim = document.getElementById('input-nim');
        const divNip = document.getElementById('input-nip');

        divNim.classList.add('hidden');
        divNip.classList.add('hidden');
        
        // Reset required attribute agar tidak error validasi HTML5 saat hidden
        nimInput.required = false;
        nipInput.required = false;

        if (role === 'mahasiswa') {
            divNim.classList.remove('hidden');
            nimInput.required = true;
            say("Input Mahasiswa 🎓");
        } else if (role === 'dosen') {
            divNip.classList.remove('hidden');
            nipInput.required = true;
            say("Input Dosen 👨‍🏫");
        }
    }

    // --- 5. MATA IKUT KURSOR ---
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

    // --- 6. SHY MODE (PASSWORD) ---
    function setShy(isShy) {
        if (isShy) {
            catContainer.classList.add('shy');
            say("Ssstt.. Rahasia! 🙈");
        } else {
            catContainer.classList.remove('shy');
            say("Oke, aman! 👍");
        }
    }
    
    [passInput, confInput].forEach(el => {
        el.addEventListener('focus', () => setShy(true));
        el.addEventListener('blur', () => setShy(false));
    });

    function toggleAllPasswords() {
        const type = passInput.type === "password" ? "text" : "password";
        passInput.type = type;
        confInput.type = type;
        
        // Icon change logic
        const icon = document.getElementById('eye-icon-global');
        if(type === 'text') {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            if(!catContainer.classList.contains('shy')) setShy(true);
        } else {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
        passInput.focus();
    }

    // --- 7. LOGIKA SUBMIT AJAX (ADMIN MODE) ---
    document.getElementById('createMemberForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validasi Password Match
        if (passInput.value !== confInput.value) {
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok',
                text: 'Konfirmasi password harus sama!',
                confirmButtonColor: '#DB2777'
            });
            return;
        }

        const btn = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');
        const originalText = btnText.innerText;
        
        btn.disabled = true;
        btnText.innerText = 'Menyimpan...';

        try {
            const formData = new FormData(this);
            
            // MAP LOGIC: Tentukan 'identity_number' mana yang dikirim ke backend
            // Backend biasanya mengharapkan 'identity_number', bukan '_mhs' atau '_dosen'
            // Kita inject manual ke formData
            const role = roleInput.value;
            let finalId = '';
            
            if(role === 'mahasiswa') finalId = nimInput.value;
            else if(role === 'dosen') finalId = nipInput.value;

            formData.append('identity_number', finalId);

            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.status === 422) {
                const data = await response.json();
                let errorMessages = Object.values(data.errors).flat().join('\n');
                Swal.fire({ icon: 'error', title: 'Validasi Gagal', text: errorMessages, confirmButtonColor: '#DB2777' });
            } else if (response.ok || response.status === 200 || response.redirected) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Anggota berhasil ditambahkan.',
                    timer: 2000,
                    showConfirmButton: false,
                    willClose: () => { window.location.href = "{{ route('members.index') }}"; }
                });
            } else {
                throw new Error('Kesalahan server.');
            }
        } catch (error) {
            console.error(error);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menyimpan data.', confirmButtonColor: '#DB2777' });
        } finally {
            if (!document.querySelector('.swal2-icon-success')) {
                btn.disabled = false;
                btnText.innerText = originalText;
            }
        }
    });

    // Init
    toggleInputs();
    updateContactUI();
    updateNimUI();

</script>
@endsection