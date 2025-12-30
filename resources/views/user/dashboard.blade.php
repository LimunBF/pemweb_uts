@extends('layouts.app')

@section('content')
<div class="container mx-auto relative">

    {{-- Banner Selamat Datang --}}
    <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-8 mb-8 text-white shadow-lg flex items-center justify-between relative overflow-hidden min-h-[180px]">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="mt-2 text-pink-100 opacity-90">Selamat datang di Dashboard Peminjaman Laboratorium PTIK.</p>
        </div>
        <div class="absolute right-4 -bottom-4 z-20 hidden md:block">
            <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Animated-Fluent-Emojis/master/Emojis/People/Person%20Raising%20Hand.png" alt="Character Waving" class="w-48 h-auto waving-character filter drop-shadow-xl">
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>
    </div>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center animate-fade-in-down">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <div>
                <p class="font-bold">Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Alert Error Global --}}
    @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm flex items-start animate-pulse">
            <svg class="w-6 h-6 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <div>
                <p class="font-bold">Gagal Menyimpan Perubahan:</p>
                <ul class="list-disc list-inside text-sm mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: KARTU PROFIL --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-md border border-pink-100 p-6 h-full relative group hover:shadow-xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-2 bg-lab-text rounded-t-2xl"></div>
                
                {{-- Header Kartu --}}
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil Saya
                    </h3>
                    
                    {{-- TOMBOL EDIT (MEMICU MODAL) --}}
                    <button onclick="openModal()" class="text-gray-400 hover:text-white hover:bg-lab-pink-btn transition-all p-2 rounded-full shadow-sm border border-gray-100 hover:border-lab-pink-btn group-edit" title="Edit Profil">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                </div>

                <div class="space-y-5">
                    <div class="border-b border-gray-100 pb-2">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Nama Lengkap</label>
                        <div class="text-lg font-medium text-lab-text">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">NIM / Identitas</label>
                        <div class="text-lg font-medium text-gray-700 font-mono">{{ Auth::user()->identity_number ?? '-' }}</div>
                    </div>
                    <div class="border-b border-gray-100 pb-2">
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">No. WhatsApp</label>
                        <div class="text-lg font-medium text-gray-700">{{ Auth::user()->contact ?? '-' }}</div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 uppercase font-semibold tracking-wider">Email</label>
                        <div class="text-base text-gray-600 truncate">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: MENU AKSI --}}
        <div class="lg:col-span-2 flex flex-col gap-6">
            <a href="{{ route('student.loan.form') }}" class="group relative bg-white rounded-2xl shadow-md border border-pink-100 p-8 flex flex-col md:flex-row items-center justify-between hover:shadow-xl hover:border-lab-pink-btn transition-all duration-300 cursor-pointer overflow-hidden">
                <div class="absolute inset-0 bg-lab-pink opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                <div class="relative z-10 text-center md:text-left mb-6 md:mb-0">
                    <h2 class="text-3xl font-bold text-lab-text mb-2 group-hover:text-lab-pink-btn transition-colors">Mulai Peminjaman</h2>
                    <p class="text-gray-500 max-w-md">Isi formulir pengajuan untuk meminjam alat laboratorium.</p>
                    <span class="mt-4 inline-block px-6 py-2 bg-lab-pink-btn text-white rounded-full text-sm font-semibold shadow-md group-hover:bg-lab-text transition-colors">Isi Formulir &rarr;</span>
                </div>
                <div class="relative z-10 w-32 h-32 bg-lab-pink rounded-full flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-16 h-16 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </a>

            <a href="{{ route('student.loans') }}" class="group bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex items-center hover:shadow-lg hover:border-blue-300 transition-all duration-300">
                <div class="p-4 bg-blue-50 rounded-xl text-blue-600 mr-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800 group-hover:text-blue-700 transition-colors">Riwayat Peminjaman</h3>
                    <p class="text-sm text-gray-500">Lihat status barang dan deadline.</p>
                </div>
                <div class="ml-auto text-gray-300 group-hover:text-blue-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        </div>
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL EDIT PROFIL (ANIMATED & 2-STEP) --}}
{{-- ========================================== --}}
<div id="profileModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    
    {{-- Backdrop dengan Blur --}}
    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        
        {{-- Konten Modal --}}
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full scale-95 opacity-0" id="modalContent">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Profil Saya
                </h3>
                <button type="button" onclick="closeModal()" class="text-pink-200 hover:text-white transition-colors focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('student.profile.update') }}" method="POST" class="p-6" id="profileForm">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    {{-- Input Email --}}
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Kampus</label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition text-gray-800">
                    </div>

                    {{-- Input Kontak (HP) --}}
                    <div class="relative">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-sm font-bold text-gray-700">No. WhatsApp / HP</label>
                            <span id="contact-counter" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">0/13</span>
                        </div>
                        <input type="number" name="contact" id="contact" value="{{ old('contact', Auth::user()->contact) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition text-gray-800"
                            placeholder="08xxxxxxxxxx">
                        <p class="text-xs text-gray-400 mt-1">Gunakan format 08...</p>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-dashed border-gray-200 my-2"></div>

                    {{-- Input Password Baru --}}
                    <div class="bg-pink-50 p-4 rounded-xl border border-pink-100 transition-all duration-300" id="passwordSection">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-1 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Ganti Password (Opsional)
                        </label>
                        
                        <div class="relative">
                            <input type="password" name="password" id="passwordInput" 
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition text-gray-800 bg-white"
                                placeholder="Isi hanya jika ingin mengganti">
                            
                            {{-- TOMBOL LIHAT PASSWORD --}}
                            <button type="button" onclick="togglePasswordVisibility('passwordInput', 'eyeIcon1')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-lab-pink-btn transition focus:outline-none">
                                <svg id="eyeIcon1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        
                        {{-- Notifikasi Kecil --}}
                        <div class="mt-2 flex items-start text-xs text-blue-700 bg-blue-50 p-2 rounded-lg border border-blue-200">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p>Jika password diganti, password baru akan dikirimkan ke <strong>Email Kampus</strong> Anda sebagai cadangan.</p>
                        </div>
                    </div>

                    {{-- Konfirmasi Password (Hidden Awalnya) --}}
                    <div id="confirmPasswordSection" class="hidden overflow-hidden transition-all duration-500 ease-in-out">
                        <div class="bg-lab-text p-4 rounded-xl text-white shadow-lg animate-fade-in-up">
                            <label class="block text-sm font-bold text-pink-200 mb-1">Konfirmasi Password Baru</label>
                            
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="passwordConfirmInput"
                                    class="w-full px-4 py-2 pr-10 border-2 border-pink-500 bg-gray-800 rounded-xl focus:ring-2 focus:ring-pink-400 focus:border-transparent outline-none transition text-white"
                                    placeholder="Ketik ulang password baru">
                                
                                {{-- TOMBOL LIHAT PASSWORD KONFIRMASI --}}
                                <button type="button" onclick="togglePasswordVisibility('passwordConfirmInput', 'eyeIcon2')" class="absolute inset-y-0 right-0 px-3 flex items-center text-pink-300 hover:text-white transition focus:outline-none">
                                    <svg id="eyeIcon2" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>

                            <p class="text-xs text-pink-300 mt-2">Demi keamanan, silakan verifikasi password baru Anda sebelum menyimpan.</p>
                        </div>
                    </div>
                </div>

                {{-- Footer Tombol --}}
                <div class="mt-8 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition font-bold text-sm">
                        Batal
                    </button>
                    <button type="submit" id="saveButton" class="px-5 py-2.5 bg-lab-pink-btn text-white rounded-xl hover:bg-pink-700 transition font-bold text-sm shadow-md hover:shadow-lg transform active:scale-95 flex items-center">
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // --- 1. MODAL ANIMATION ---
    const modal = document.getElementById('profileModal');
    const backdrop = document.getElementById('modalBackdrop');
    const content = document.getElementById('modalContent');
    const body = document.querySelector('body');

    function openModal() {
        modal.classList.remove('hidden');
        void modal.offsetWidth; 
        backdrop.classList.remove('opacity-0');
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
        body.style.overflow = 'hidden';
        resetPasswordLogic();
    }

    function closeModal() {
        backdrop.classList.add('opacity-0');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            body.style.overflow = 'auto';
        }, 300);
    }

    // --- 2. COUNTER NO HP ---
    const contactInput = document.getElementById('contact');
    const contactCounter = document.getElementById('contact-counter');

    function updateCounter() {
        let val = contactInput.value;
        if (val.length > 13) contactInput.value = val.slice(0, 13);
        contactCounter.innerText = `${contactInput.value.length}/13`;
        
        if (contactInput.value.length >= 10 && contactInput.value.length <= 13) {
            contactCounter.classList.replace('text-gray-400', 'text-green-600');
            contactCounter.classList.replace('bg-gray-100', 'bg-green-100');
        } else {
            contactCounter.classList.replace('text-green-600', 'text-gray-400');
            contactCounter.classList.replace('bg-green-100', 'bg-gray-100');
        }
    }
    contactInput.addEventListener('input', updateCounter);
    updateCounter(); 

    // --- 3. PASSWORD 2-STEP LOGIC ---
    const form = document.getElementById('profileForm');
    const passInput = document.getElementById('passwordInput');
    const confirmSection = document.getElementById('confirmPasswordSection');
    const confirmInput = document.getElementById('passwordConfirmInput');
    const saveBtn = document.getElementById('saveButton');
    const btnText = saveBtn.querySelector('span');

    let isConfirmationStep = false;

    function resetPasswordLogic() {
        isConfirmationStep = false;
        confirmSection.classList.add('hidden');
        confirmInput.value = '';
        confirmInput.removeAttribute('required');
        btnText.innerText = "Simpan Perubahan";
        saveBtn.classList.remove('bg-lab-text', 'hover:bg-gray-900');
        saveBtn.classList.add('bg-lab-pink-btn', 'hover:bg-pink-700');
        
        // Reset juga visibilitas password ke hidden
        passInput.type = 'password';
        confirmInput.type = 'password';
    }

    form.addEventListener('submit', function(e) {
        if (passInput.value.length > 0) {
            if (!isConfirmationStep) {
                e.preventDefault(); 
                confirmSection.classList.remove('hidden');
                confirmInput.setAttribute('required', 'true');
                confirmInput.focus();
                isConfirmationStep = true;
                btnText.innerText = "Konfirmasi & Ganti Password";
                saveBtn.classList.remove('bg-lab-pink-btn', 'hover:bg-pink-700');
                saveBtn.classList.add('bg-lab-text', 'hover:bg-gray-900');
                content.scrollTo({ top: content.scrollHeight, behavior: 'smooth' });
                return;
            }
        }
    });

    passInput.addEventListener('input', function() {
        if(this.value.length === 0) {
            resetPasswordLogic();
        }
    });

    // --- 4. TOGGLE PASSWORD VISIBILITY ---
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        // Icon Paths
        const eyeOpenPath = "M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z";
        const eyeClosedPath = "M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21";

        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${eyeClosedPath}" />`;
        } else {
            input.type = "password";
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${eyeOpenPath}" />`;
        }
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            openModal();
        });
    @endif
</script>
@endsection