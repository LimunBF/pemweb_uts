@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-4">
    
    {{-- Breadcrumb --}}
    <div class="mb-4 flex items-center text-sm text-gray-500">
        <a href="{{ route('members.index') }}" class="hover:text-lab-pink-btn transition">Manajemen Anggota</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-bold">Edit Anggota</span>
    </div>

    <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-pink-100">
        
        {{-- Header Form --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn px-8 py-6 text-white flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Data Anggota
                </h1>
                <p class="text-pink-100 text-sm mt-1">Perbarui informasi anggota atau reset password.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mx-8 mt-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg animate-pulse">
                <p class="text-red-700 font-bold text-sm">Gagal Menyimpan:</p>
                <ul class="list-disc list-inside text-xs text-red-600 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('members.update', $member->id) }}" method="POST" class="p-8" id="editMemberForm">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                {{-- KOLOM KIRI: Identitas & Akun (Email Pindah Sini) --}}
                <div class="space-y-5">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b pb-2">Identitas & Akun</h3>

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition">
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Role / Jabatan</label>
                        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition bg-white">
                            <option value="mahasiswa" {{ $member->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen" {{ $member->role == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="admin" {{ $member->role == 'admin' ? 'selected' : '' }}>Admin Lab</option>
                        </select>
                    </div>

                    {{-- NIM/NIP --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-sm font-bold text-gray-700">NIM / NIP</label>
                            {{-- COUNTER --}}
                            <span id="nim-counter" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full transition-colors duration-300">0/8</span>
                        </div>
                        <input type="text" name="identity_number" id="identity_number" value="{{ old('identity_number', $member->identity_number) }}" required maxlength="8"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition font-mono">
                    </div>

                    {{-- Email (PINDAH KE SINI) --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Email Kampus</label>
                        <input type="email" name="email" value="{{ old('email', $member->email) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition">
                    </div>
                </div>

                {{-- KOLOM KANAN: Kontak & Reset Password (Naik ke Atas) --}}
                <div class="space-y-5">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b pb-2">Kontak & Keamanan</h3>

                    {{-- Kontak HP (Posisi Paling Atas di Kanan) --}}
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-sm font-bold text-gray-700">No. WhatsApp / HP</label>
                            {{-- COUNTER --}}
                            <span id="contact-counter" class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full transition-colors duration-300">0/13</span>
                        </div>
                        <input type="number" name="contact" id="contact" value="{{ old('contact', $member->contact) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition"
                            placeholder="08xxxxxxxxxx">
                    </div>

                    {{-- SECTION GANTI PASSWORD (ANIMATED - Langsung di bawah HP) --}}
                    <div class="bg-pink-50 p-5 rounded-xl border border-pink-100 transition-all duration-300">
                        <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Reset Password (Opsional)
                        </label>
                        
                        <div class="relative mb-2">
                            <input type="password" name="password" id="passwordInput" 
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition bg-white"
                                placeholder="Isi untuk mereset password user ini">
                            
                            {{-- Toggle Eye --}}
                            <button type="button" onclick="togglePasswordVisibility('passwordInput', 'eyeIcon1')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-lab-pink-btn transition focus:outline-none">
                                <svg id="eyeIcon1" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                        {{-- Notifikasi Email --}}
                        <div id="emailNotice" class="hidden flex items-start text-xs text-blue-700 bg-blue-100 p-2 rounded-lg border border-blue-200">
                            <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <p>Password baru akan dikirim otomatis ke email anggota.</p>
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div id="confirmSection" class="hidden mt-4 overflow-hidden transition-all duration-500">
                            <div class="bg-gray-800 p-3 rounded-lg text-white animate-fade-in-up">
                                <label class="block text-xs font-bold text-pink-300 mb-1">Konfirmasi Password Baru</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="passwordConfirmInput"
                                        class="w-full px-3 py-2 pr-10 border border-pink-500 bg-gray-700 rounded-lg focus:ring-1 focus:ring-pink-400 outline-none text-white text-sm"
                                        placeholder="Ketik ulang password">
                                    
                                    <button type="button" onclick="togglePasswordVisibility('passwordConfirmInput', 'eyeIcon2')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-white transition focus:outline-none">
                                        <svg id="eyeIcon2" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                <a href="{{ route('members.index') }}" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition font-bold">
                    Batal
                </a>
                {{-- Tombol ini tidak pakai 'w-full', jadi ukurannya tidak akan melebar --}}
                <button type="submit" id="saveBtn" class="px-6 py-3 bg-lab-pink-btn text-white rounded-xl hover:bg-pink-700 transition font-bold shadow-lg transform active:scale-95 flex items-center">
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // --- 1. TOGGLE PASSWORD VISIBILITY ---
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        const eyeOpen = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
        const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`;

        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = eyeClosed;
        } else {
            input.type = "password";
            icon.innerHTML = eyeOpen;
        }
    }

    // --- 2. LOGIC 2-STEP PASSWORD ---
    const passInput = document.getElementById('passwordInput');
    const confirmSection = document.getElementById('confirmSection');
    const confirmInput = document.getElementById('passwordConfirmInput');
    const emailNotice = document.getElementById('emailNotice');
    const saveBtn = document.getElementById('saveBtn');
    const btnText = saveBtn.querySelector('span');

    passInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            confirmSection.classList.remove('hidden');
            emailNotice.classList.remove('hidden');
            confirmInput.setAttribute('required', 'true');
            
            btnText.innerText = "Konfirmasi & Simpan";
            saveBtn.classList.remove('bg-lab-pink-btn', 'hover:bg-pink-700');
            saveBtn.classList.add('bg-red-800', 'hover:bg-red-900');
        } else {
            confirmSection.classList.add('hidden');
            emailNotice.classList.add('hidden');
            confirmInput.value = '';
            confirmInput.removeAttribute('required');
            
            btnText.innerText = "Simpan Perubahan";
            saveBtn.classList.add('bg-lab-pink-btn', 'hover:bg-pink-700');
            saveBtn.classList.remove('bg-red-800', 'hover:bg-red-900');
        }
    });

    // --- 3. COUNTER UI (UPDATE + COLOR CHANGE) ---
    const contactInput = document.getElementById('contact');
    const contactCounter = document.getElementById('contact-counter');
    const nimInput = document.getElementById('identity_number');
    const nimCounter = document.getElementById('nim-counter');

    function updateUI() {
        // --- LOGIC HP ---
        let hpVal = contactInput.value;
        if(hpVal.length > 13) contactInput.value = hpVal.slice(0, 13);
        contactCounter.innerText = `${contactInput.value.length}/13`;
        
        if (contactInput.value.length >= 10 && contactInput.value.length <= 13) {
            contactCounter.classList.replace('text-gray-400', 'text-green-600');
            contactCounter.classList.replace('bg-gray-100', 'bg-green-100');
        } else {
            contactCounter.classList.replace('text-green-600', 'text-gray-400');
            contactCounter.classList.replace('bg-green-100', 'bg-gray-100');
        }
        
        // --- LOGIC NIM ---
        let nimVal = nimInput.value;
        if(nimVal.length > 8) nimInput.value = nimVal.slice(0, 8);
        nimCounter.innerText = `${nimInput.value.length}/8`;

        if (nimInput.value.length === 8) {
            nimCounter.classList.replace('text-gray-400', 'text-green-600');
            nimCounter.classList.replace('bg-gray-100', 'bg-green-100');
        } else {
            nimCounter.classList.replace('text-green-600', 'text-gray-400');
            nimCounter.classList.replace('bg-green-100', 'bg-gray-100');
        }
    }

    contactInput.addEventListener('input', updateUI);
    nimInput.addEventListener('input', updateUI);
    updateUI(); 
</script>
@endsection