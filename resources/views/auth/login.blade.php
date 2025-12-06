<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lab PTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#FFC0CB', 
                        'lab-pink-dark': '#FF91A4',
                        'lab-pink-btn': '#db2777',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center font-sans">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-pink-100">
        
        {{-- Header Pink --}}
        <div class="bg-lab-pink p-8 text-center">
            <div class="mx-auto bg-white w-16 h-16 rounded-full flex items-center justify-center text-pink-600 mb-4 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Lab PTIK</h2>
            <p class="text-gray-700 text-sm mt-1">Silakan login sistem</p>
        </div>

        {{-- Form Login --}}
        <div class="p-8">
            {{-- Pesan Error --}}
            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block">{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf 

                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Email</label>
                    <input type="email" name="email" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                        placeholder="admin@lab.com">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition"
                        placeholder="********">
                </div>

                <button type="submit" 
                    class="w-full bg-lab-pink-btn hover:bg-pink-700 text-white font-bold py-3 rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>
</body>
</html>