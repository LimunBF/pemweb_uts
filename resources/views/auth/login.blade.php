<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Lab PTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#FFC0CB',       
                        'lab-pink-dark': '#FF91A4',  
                        'lab-pink-btn': '#DB2777',   
                        'lab-text': '#881337',       
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center font-sans">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-pink-100 transform transition-all hover:scale-[1.01] duration-300">
        
        <!-- HEADER -->
        <div class="bg-lab-pink p-8 text-center relative">
            <div class="mx-auto bg-white w-20 h-20 rounded-full flex items-center justify-center text-lab-pink-btn mb-4 shadow-md ring-4 ring-pink-200">
                <!-- Icon Kunci -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-lab-text tracking-wide">Lab PTIK</h2>
            <p class="text-gray-700 text-sm mt-2 font-medium">Silakan Login</p>
        </div>

        <!-- FORMULIR LOGIN -->
        <div class="p-8 pt-8">
            
            <!--Sukses Register-->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!--Error Login-->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded text-sm shadow-sm flex items-start">
                    <div>
                        <p class="font-bold">Gagal Masuk</p>
                        <p>{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf 

                <!-- Input Email -->
                <div class="mb-5">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" id="email" required autofocus
                        class="w-full pl-4 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 transition-all bg-gray-50 focus:bg-white"
                        placeholder="email">
                </div>

                <!-- Input Password -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-gray-700 text-sm font-bold">Kata Sandi</label>
                    </div>
                    <input type="password" name="password" id="password" required
                        class="w-full pl-4 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-lab-pink-btn focus:ring-2 focus:ring-pink-200 transition-all bg-gray-50 focus:bg-white"
                        placeholder="••••••••">
                </div>

                <!-- Tombol Masuk -->
                <button type="submit" 
                    class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-1">
                    Masuk Sekarang
                </button>
            </form>
        </div>
        
        <!-- FOOTER -->
        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center space-y-2">
            <!-- Link Daftar -->
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-lab-pink-btn hover:text-pink-800 font-bold transition ml-1 hover:underline">
                    Daftar Akun Baru
                </a>
            </p>
            
            <!-- Link Lupa Password -->
            <p class="text-xs text-gray-400 mt-2">
                Lupa password? Hubungi 
                <a href="#" class="text-gray-500 hover:text-lab-pink-btn font-semibold transition hover:underline">
                    Admin
                </a>
            </p>
        </div>

    </div>

</body>
</html>