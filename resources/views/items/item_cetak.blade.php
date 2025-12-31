<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris Lab PTIK_{{ date('d-m-Y') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink': '#db2777',
                        'lab-dark': '#1f2937',
                    },
                    screens: {
                        'print': {'raw': 'print'},
                    }
                }
            }
        }
    </script>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { 
                background-color: white !important; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
            }
            .paper {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100% !important;
                min-height: auto !important;
            }
            @page {
                size: A4 landscape; /* Landscape agar tabel muat banyak */
                margin: 0; 
            }
        }

        /* PREVIEW MODE */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e5e7eb;
            padding: 2rem 0;
        }

        /* SIMULASI KERTAS A4 LANDSCAPE */
        .paper {
            width: 297mm; /* Lebar A4 Landscape */
            min-height: 210mm; /* Tinggi A4 Landscape */
            background-color: white;
            margin: 0 auto;
            padding: 15mm;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .table-header {
            background-color: #db2777 !important;
            color: white !important;
        }
        
        tr {
            break-inside: avoid; /* Mencegah baris terpotong antar halaman */
        }
    </style>
</head>
<body>

    {{-- NAVIGASI (Hanya tampil di layar) --}}
    <div class="no-print fixed top-0 left-0 w-full bg-white/90 backdrop-blur-sm border-b border-gray-200 p-3 flex justify-between items-center shadow-sm z-50">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-lab-pink text-white rounded flex items-center justify-center font-bold text-xs">PDF</div>
            <div>
                <h1 class="font-bold text-gray-800 text-sm leading-tight">Pratinjau Cetak Inventaris</h1>
                <p class="text-[10px] text-gray-500">Ukuran A4 Landscape</p>
            </div>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-4 py-1.5 bg-lab-pink text-white rounded hover:bg-pink-700 font-bold text-xs flex items-center gap-2 shadow-sm transition transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    {{-- KERTAS KERJA --}}
    <div class="paper">
        
        {{-- KOP SURAT --}}
        <div class="border-b-2 border-lab-pink pb-3 mb-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                {{-- LOGO (Gunakan asset jika ada) --}}
                <div class="w-16 h-16 flex items-center justify-center">
                    {{-- Pastikan path logo sesuai dengan project Anda --}}
                    <img src="{{ asset('templates/logo.png') }}" 
                         alt="Logo" 
                         onerror="this.style.display='none'"
                         class="w-full h-full object-contain">
                </div>

                <div>
                    <h1 class="text-xl font-extrabold text-lab-dark uppercase tracking-tight leading-none">Lab. PTIK</h1>
                    <p class="text-sm font-semibold text-gray-600">Pendidikan Teknik Informatika dan Komputer</p>
                    <p class="text-[10px] text-gray-500 mt-0.5">Jl. A. Yani No.200, Dusun II, Pabelan, Kec. Kartasura, Kabupaten Sukoharjo</p>
                    <p class="text-[10px] text-gray-500 mt-0.5">Jawa Tengah 57161</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-lg font-bold text-lab-pink uppercase tracking-wide">Daftar Inventaris</h2>
                <p class="text-[10px] text-gray-500 mt-1">Tanggal Cetak: {{ date('d F Y') }}</p>
            </div>
        </div>

        {{-- RINGKASAN DATA --}}
        <div class="mb-5 bg-gray-50 rounded border border-gray-100 p-3 flex justify-between items-center text-xs">
            <div>
                <span class="block text-gray-400 uppercase font-bold text-[10px]">Total Aset</span>
                <span class="font-bold text-gray-800 text-lg">{{ $items->count() }} Item</span>
            </div>
            <div>
                <span class="block text-gray-400 uppercase font-bold text-[10px]">Aset Tersedia</span>
                <span class="font-bold text-green-600 text-lg">{{ $items->sum('stok_ready') }} Unit</span>
            </div>
            <div>
                <span class="block text-gray-400 uppercase font-bold text-[10px]">Sedang Dipinjam</span>
                <span class="font-bold text-yellow-600 text-lg">{{ $items->sum('stok_dipinjam') }} Unit</span>
            </div>
            <div class="text-right">
                <span class="block text-gray-400 uppercase font-bold text-[10px]">Dicetak Oleh</span>
                <span class="font-bold text-gray-800">{{ auth()->user()->name ?? 'Administrator' }}</span>
            </div>
        </div>

        {{-- TABEL DATA --}}
        <table class="w-full text-xs text-left border border-gray-300 mb-8">
            <thead>
                <tr class="table-header text-white uppercase text-[10px] tracking-wider">
                    <th class="p-2 border border-gray-300 w-10 text-center">No</th>
                    <th class="p-2 border border-gray-300 w-32">Kode Alat</th>
                    <th class="p-2 border border-gray-300 w-1/4">Nama Barang</th>
                    <th class="p-2 border border-gray-300">Deskripsi</th>
                    <th class="p-2 border border-gray-300 w-16 text-center">Total</th>
                    <th class="p-2 border border-gray-300 w-16 text-center">Pinjam</th>
                    <th class="p-2 border border-gray-300 w-16 text-center">Ready</th>
                    <th class="p-2 border border-gray-300 w-24 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="p-2 border border-gray-300 text-center font-medium text-gray-500">{{ $index + 1 }}</td>
                    
                    <td class="p-2 border border-gray-300 font-mono font-bold text-gray-700">
                        {{ $item->kode_alat }}
                    </td>
                    
                    <td class="p-2 border border-gray-300 font-bold text-gray-800">
                        {{ $item->nama_alat }}
                    </td>
                    
                    <td class="p-2 border border-gray-300 text-gray-600">
                        {{ \Illuminate\Support\Str::words($item->deskripsi, 10, '...') ?? '-' }}
                    </td>
                    
                    <td class="p-2 border border-gray-300 text-center font-bold">
                        {{ $item->jumlah_total }}
                    </td>
                    
                    <td class="p-2 border border-gray-300 text-center text-yellow-600 font-semibold">
                        {{ $item->stok_dipinjam ?? 0 }}
                    </td>
                    
                    <td class="p-2 border border-gray-300 text-center text-green-600 font-bold">
                        {{ $item->stok_ready ?? $item->jumlah_total }}
                    </td>
                    
                    <td class="p-2 border border-gray-300 text-center">
                         <span class="font-bold text-[10px] uppercase px-2 py-0.5 rounded
                            @if($item->jumlah_total == 0) bg-red-100 text-red-600
                            @elseif(($item->stok_ready ?? $item->jumlah_total) == 0) bg-yellow-100 text-yellow-600
                            @else bg-green-100 text-green-600 @endif
                        ">
                            @if($item->jumlah_total == 0)
                                Stok Kosong
                            @elseif(($item->stok_ready ?? $item->jumlah_total) == 0)
                                Dipinjam
                            @else
                                Tersedia
                            @endif
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-6 text-center text-gray-400 italic border border-gray-300 bg-gray-50">
                        Tidak ada data inventaris yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- AREA TANDA TANGAN --}}
        <div class="flex justify-end mt-10 page-break-inside-avoid">
            <div class="text-center w-56">
                <p class="text-xs text-gray-600 mb-1">Surakarta, {{ date('d F Y') }}</p>
                <p class="text-xs font-bold text-gray-800 mb-12">Kepala Laboratorium</p>
                
                <p class="text-xs font-bold text-gray-900 border-b border-gray-800 inline-block pb-0.5 px-2">    Yusfia Hafid Aristyagama S.T., M.T.      </p>
                <p class="text-xs text-gray-500 mt-1">NIP.199105242019031016</p>
            </div>
        </div>

    </div>

</body>
</html>