<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman - Lab PTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#FCE7F3',
                        'lab-pink-dark': '#FF91A4',
                        'lab-text': '#590D22',
                        'lab-pink-btn':'#DB2777',
                    },
                    fontFamily: { 'poppins': ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');</style>
</head>
<body class="bg-white font-poppins antialiased text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR (Sama seperti sebelumnya) -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
            <div class="h-16 flex items-center justify-center border-b border-gray-200">
                <h1 class="text-xl font-bold text-lab-text">Laboratorium PTIK</h1> 
            </div>
            <nav class="flex-1 mt-6 px-4 space-y-2">
                <a href="{{ route('dashboard_admin') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-lab-pink hover:text-gray-900 rounded-lg transition-colors">
                    Dashboard
                </a>
                <a href="{{ route('inventaris') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-lab-pink hover:text-gray-900 rounded-lg transition-colors">
                    Inventaris
                </a>
                <!-- Menu Peminjaman Aktif -->
                <a href="#" class="flex items-center px-4 py-3 bg-lab-text text-white rounded-lg shadow-md transition-colors">
                    Peminjaman
                </a>
                <!-- Menu Daftar Anggota -->
                <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-lab-pink hover:text-gray-900 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    Anggota
                </a>
            </nav>
        </aside>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm">
                <div class="flex-1"></div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-semibold text-gray-800">Admin Lab</span>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-8">
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-bold text-lab-text">Daftar Peminjaman Barang</h2>
                    <button class="px-4 py-2 bg-lab-pink-btn text-white rounded-md text-sm font-semibold hover:bg-pink-700">
                        + Catat Peminjaman
                    </button>
                </div>

                <!-- TABEL DATA PEMINJAMAN -->
                <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
                    <table class="min-w-full divide-y divide-pink-200">
                        <thead class="bg-lab-pink">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Tgl Pinjam</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($peminjaman as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->user->name ?? 'User Tidak Dikenal' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->task->name ?? 'Barang Dihapus' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->tanggal_pinjam }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item->status == 'dipinjam')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Dipinjam
                                        </span>
                                    @elseif($item->status == 'dikembalikan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Dikembalikan
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $peminjaman->links() }}
                </div>

            </main>
        </div>
    </div>
</body>
</html>