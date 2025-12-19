@extends('layouts.app')

@section('content')
{{-- Load SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* 1. Animasi Fade In Up */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-element {
        opacity: 0; animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* 2. Custom Tooltip CSS */
    .custom-tooltip-container {
        position: relative; display: inline-flex; align-items: center; margin-left: 0.5rem;
        cursor: help; z-index: 10; flex-shrink: 0;
    }
    .custom-tooltip-text {
        visibility: hidden; width: max-content; max-width: 220px;
        background-color: #1f2937; color: #fff; text-align: center;
        border-radius: 8px; padding: 6px 10px; position: absolute;
        z-index: 50; bottom: 135%; left: 50%; transform: translateX(-50%) scale(0.95);
        opacity: 0; transition: all 0.2s ease-in-out; pointer-events: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); font-size: 0.7rem; font-weight: 500;
        line-height: 1.4;
    }
    .custom-tooltip-text::after {
        content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px;
        border-width: 5px; border-style: solid; border-color: #1f2937 transparent transparent transparent;
    }
    .custom-tooltip-container:hover { z-index: 60; }
    .custom-tooltip-container:hover .custom-tooltip-text {
        visibility: visible; opacity: 1; transform: translateX(-50%) scale(1);
    }
    /* Tooltip Align Left */
    .tooltip-align-left .custom-tooltip-text { left: -8px; transform: translateX(0) scale(0.95); text-align: left; }
    .tooltip-align-left:hover .custom-tooltip-text { transform: translateX(0) scale(1); }
    .tooltip-align-left .custom-tooltip-text::after { left: 15px; margin-left: 0; }
</style>

<div class="w-full">
    
    {{-- Tombol Kembali --}}
    <div class="animate-element" style="animation-delay: 0.05s;">
        <a href="{{ route('members.index') }}" class="inline-flex items-center text-gray-500 hover:text-lab-pink-btn mb-6 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Anggota
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-pink-100 overflow-hidden animate-element" style="animation-delay: 0.1s;">
        
        {{-- Header Form --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-6 text-white">
            <h2 class="text-2xl font-bold">Tambah Anggota Baru</h2>
            <p class="text-pink-100 text-sm mt-1">Isi formulir untuk mendaftarkan mahasiswa baru ke dalam sistem.</p>
        </div>

        {{-- Body Form --}}
        <div class="p-8">
            {{-- Tambahkan ID form agar bisa diambil JS --}}
            <form id="createMemberForm" action="{{ route('members.store') }}" method="POST">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="mb-6 animate-element" style="animation-delay: 0.2s;">
                    <label for="name" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap
                        <div class="custom-tooltip-container tooltip-align-left">
                            <svg class="w-4 h-4 text-gray-400 hover:text-lab-pink-btn transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="custom-tooltip-text">Gunakan nama lengkap sesuai KTP/KTM.</span>
                        </div>
                    </label>
                    <input type="text" name="name" id="name"
                           class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border transition-colors" 
                           placeholder="Contoh: Budi Santoso" required>
                </div>

                {{-- Grid 1: NIM & Kontak --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    {{-- NIM --}}
                    <div class="animate-element" style="animation-delay: 0.3s;">
                        <label for="identity_number" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            NIM
                            <div class="custom-tooltip-container tooltip-align-left">
                                <svg class="w-4 h-4 text-gray-400 hover:text-lab-pink-btn transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="custom-tooltip-text">NIM wajib unik & aktif.</span>
                            </div>
                        </label>
                        <input type="text" name="identity_number" id="identity_number"
                               class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border transition-colors" 
                               placeholder="Contoh: 12345678" required>
                    </div>

                    {{-- Kontak --}}
                    <div class="animate-element" style="animation-delay: 0.35s;">
                        <label for="contact" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            No. HP / WhatsApp
                            <div class="custom-tooltip-container">
                                <svg class="w-4 h-4 text-gray-400 hover:text-lab-pink-btn transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="custom-tooltip-text">Untuk notifikasi peminjaman.</span>
                            </div>
                        </label>
                        <input type="text" name="contact" id="contact"
                               class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border transition-colors" 
                               placeholder="Contoh: 08123456789">
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-6 animate-element" style="animation-delay: 0.4s;">
                    <label for="email" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                        Alamat Email
                        <div class="custom-tooltip-container tooltip-align-left">
                            <svg class="w-4 h-4 text-gray-400 hover:text-lab-pink-btn transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="custom-tooltip-text">Gunakan email institusi/kampus.</span>
                        </div>
                    </label>
                    <input type="email" name="email" id="email"
                           class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 px-4 border transition-colors" 
                           placeholder="nama@mahasiswa.university.ac.id" required>
                </div>

                {{-- Grid 2: Password & Confirm Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 animate-element" style="animation-delay: 0.5s;">
                    
                    {{-- Password Utama --}}
                    <div>
                        <label for="password" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            Password Akun
                            <div class="custom-tooltip-container tooltip-align-left">
                                <svg class="w-4 h-4 text-gray-400 hover:text-lab-pink-btn transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                <span class="custom-tooltip-text">Minimal 6 karakter.</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 pl-4 pr-12 border transition-colors" 
                                   placeholder="••••••••" required>
                            <button type="button" onclick="togglePassword('password', 'eye-icon-pass')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-lab-pink-btn focus:outline-none mt-1">
                                <svg id="eye-icon-pass" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                            Ulangi Password
                            <div class="custom-tooltip-container">
                                <svg class="w-4 h-4 text-gray-400 hover:text-lab-pink-btn transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="custom-tooltip-text">Wajib sama dengan password.</span>
                            </div>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="mt-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg py-3 pl-4 pr-12 border transition-colors" 
                                   placeholder="••••••••" required>
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-conf')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-lab-pink-btn focus:outline-none mt-1">
                                <svg id="eye-icon-conf" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end pt-6 border-t border-gray-100 animate-element" style="animation-delay: 0.6s;">
                    {{-- ID btn-submit untuk loading state --}}
                    <button type="submit" id="btn-submit" class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-white bg-lab-pink-btn hover:bg-pink-700 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        <span id="btn-text">Simpan Anggota</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    // 1. Logic Validasi & Submit AJAX
    document.getElementById('createMemberForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Mencegah reload halaman standar

        // Validasi Password Match (Sisi Klien)
        const pass = document.getElementById('password').value;
        const conf = document.getElementById('password_confirmation').value;

        if (pass && conf && pass !== conf) {
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Cocok',
                text: 'Pastikan konfirmasi password sama dengan password utama!',
                confirmButtonColor: '#d63384'
            });
            return;
        }

        // Siapkan Data & UI Loading
        const form = this;
        const btn = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');
        const originalText = btnText.innerText;
        
        btn.disabled = true;
        btnText.innerText = 'Menyimpan...';

        try {
            // Kirim via Fetch API
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json' // Meminta respon JSON jika error 422
                }
            });

            // Cek Status Respon
            if (response.status === 422) {
                // ERROR VALIDASI LARAVEL
                const data = await response.json();
                let errorMessages = Object.values(data.errors).flat().join('\n');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: errorMessages || 'Periksa kembali inputan Anda.',
                    confirmButtonColor: '#d63384'
                });
            } else if (response.redirected || response.status === 200) {
                // SUKSES! (Controller redirect 302 diikuti fetch jadi 200, atau success JSON)
                // Kita tampilkan notifikasi dulu, baru redirect manual
                
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Anggota baru berhasil ditambahkan.',
                    timer: 2000, // Tunggu 2 detik
                    showConfirmButton: false,
                    willClose: () => {
                        // Redirect manual setelah alert tutup
                        window.location.href = "{{ route('members.index') }}";
                    }
                });
            } else {
                throw new Error('Terjadi kesalahan yang tidak diketahui.');
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                confirmButtonColor: '#d63384'
            });
        } finally {
            // Reset Tombol jika gagal (jika sukses, halaman akan redirect jd tidak masalah)
            if (!document.querySelector('.swal2-icon-success')) {
                btn.disabled = false;
                btnText.innerText = originalText;
            }
        }
    });

    // 2. Toggle Lihat Password
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        } else {
            input.type = "password";
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>
@endsection