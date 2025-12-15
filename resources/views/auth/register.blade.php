<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Lab PTIK</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#FFC0CB', 
                        'lab-pink-btn': '#DB2777',
                        'lab-text': '#881337',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans py-10">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden border border-pink-100 transform transition-all hover:scale-[1.01] duration-300">
        
        <!-- Header -->
        <div class="bg-lab-pink p-6 text-center">
            <div class="mx-auto bg-white w-20 h-20 rounded-full flex items-center justify-center text-lab-pink-btn mb-4 shadow-md ring-4 ring-pink-200">
                <!-- Icon (Sign Up) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-lab-text tracking-wide">Lab PTIK</h2>
            <p class="text-gray-700 text-sm mt-1">Sign Up untuk bergabung Sistem Laboratorium PTIK</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            
            {{-- Menampilkan Error Validasi --}}
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-3 rounded text-sm shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 bg-gray-50 focus:bg-white transition-all"
                        placeholder="Contoh: Budi Santoso">
                </div>

                <!-- NIM & No HP -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">NIM / NIP</label>
                        <input type="text" name="identity_number" value="{{ old('identity_number') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 bg-gray-50 focus:bg-white transition-all"
                            placeholder="Nomor Induk">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">No. WhatsApp</label>
                        <input type="text" name="contact" value="{{ old('contact') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 bg-gray-50 focus:bg-white transition-all"
                            placeholder="08xxxxxxxx">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 bg-gray-50 focus:bg-white transition-all"
                        placeholder="email@mahasiswa.com">
                </div>

                <!-- Password & Konfirmasi (Grid 2 Kolom) -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 bg-gray-50 focus:bg-white transition-all"
                                placeholder="Min. 8 karakter">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Ulangi Sandi</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 bg-gray-50 focus:bg-white transition-all"
                            placeholder="Ketik ulang">
                    </div>
                </div>

                <!-- Tombol Daftar -->
                <button type="submit" 
                    class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                    Daftar Sekarang
                </button>
            </form>
        </div>
        
        <!-- FOOTER -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-lab-pink-btn hover:text-pink-800 font-bold transition ml-1 hover:underline">
                    Login di sini
                </a>
            </p>
        </div>

    </div>

</body>
</html>