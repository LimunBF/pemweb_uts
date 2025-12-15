@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-4">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('student.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-lab-pink-btn mb-4 transition duration-300 group">
        <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>

    {{-- Wrapper Gradasi --}}
    <div class="relative bg-gradient-to-br from-pink-100 via-pink-50 to-white rounded-3xl p-1.5 shadow-lg">
        <div class="bg-white rounded-2xl shadow-inner relative z-0">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-5 text-white flex justify-between items-center relative rounded-t-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Form Peminjaman</h2>
                    <p class="text-pink-100 text-xs mt-1 flex items-center opacity-90">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Maksimal 5 jenis barang berbeda.
                    </p>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('student.loan.store') }}" method="POST">
                    @csrf

                    <div class="flex flex-col lg:flex-row gap-6">
                        {{-- KIRI: Detail Waktu & Alasan --}}
                        <div class="w-full lg:w-1/3 space-y-4">
                            <div class="bg-pink-50/50 rounded-xl p-4 border border-pink-100">
                                <h3 class="text-sm font-bold text-lab-text mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Detail Waktu
                                </h3>
                                
                                {{-- Tanggal Mulai --}}
                                <div class="mb-3 relative group/tooltip">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1 flex items-center cursor-help w-max">
                                        Mulai
                                        <svg class="w-3 h-3 ml-1 text-gray-400 hover:text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </label>
                                    
                                    {{-- Tooltip --}}
                                    <div class="absolute bottom-full left-0 mb-2 hidden group-hover/tooltip:block w-48 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-left">
                                        Tanggal mulai peminjaman.
                                    </div>

                                    <input type="date" name="tanggal_pinjam" class="block w-full text-sm px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn outline-none transition" required min="{{ date('Y-m-d') }}">
                                </div>

                                {{-- Tanggal Kembali --}}
                                <div class="relative group/tooltip">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1 flex items-center cursor-help w-max">
                                        Kembali
                                        <svg class="w-3 h-3 ml-1 text-gray-400 hover:text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </label>

                                    {{-- Tooltip --}}
                                    <div class="absolute bottom-full left-0 mb-2 hidden group-hover/tooltip:block w-48 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-left">
                                        Wajib dikembalikan sebelum tenggat.
                                    </div>

                                    <input type="date" name="tanggal_kembali" class="block w-full text-sm px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn outline-none transition" required min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            {{-- Input Alasan --}}
                            <div class="relative group/tooltip">
                                <label class="block text-xs font-bold text-gray-500 mb-1 ml-1 flex items-center cursor-help w-max">
                                    Keperluan
                                    <svg class="w-3 h-3 ml-1 text-gray-400 hover:text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </label>

                                {{-- Tooltip --}}
                                <div class="absolute bottom-full left-0 mb-2 hidden group-hover/tooltip:block w-56 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-left">
                                    Jelaskan tujuan peminjaman secara detail.
                                </div>

                                <textarea name="alasan" rows="3" class="block w-full text-sm px-3 py-2 border border-gray-200 rounded-xl focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn resize-none bg-gray-50 focus:bg-white transition" placeholder="Contoh: Untuk praktikum mata kuliah Jaringan Komputer..."></textarea>
                                
                                {{-- TEKS PERINGATAN MAKSIMAL (Hidden by Default) --}}
                                <p id="max-items-warning" class="hidden text-[10px] text-red-500 font-bold mt-2 flex items-center animate-pulse">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Batas maksimal 5 barang tercapai.
                                </p>
                            </div>
                        </div>

                        {{-- KANAN: Daftar Barang --}}
                        <div class="w-full lg:w-2/3">
                            <div class="flex justify-between items-end mb-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Item Peminjaman</label>
                                <span class="text-[10px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">Otomatis cek stok</span>
                            </div>
                            
                            {{-- LIST ITEM --}}
                            <div id="items-container" class="space-y-3 pb-2">
                                
                                {{-- Item Default --}}
                                <div class="item-row bg-white border border-gray-200 rounded-xl p-3 shadow-sm hover:border-pink-200 hover:shadow-md hover:z-50 transition-all duration-300 relative group z-10">
                                    <div class="flex gap-3 items-center">
                                        <div class="flex-shrink-0 w-6 h-6 bg-gray-100 text-gray-500 text-xs font-bold rounded-lg flex items-center justify-center index-badge group-hover:bg-lab-pink-btn group-hover:text-white transition">1</div>

                                        <div class="flex-grow">
                                            <select name="items[0][item_id]" class="block w-full text-sm border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 bg-transparent cursor-pointer hover:bg-gray-50 transition" required>
                                                <option value="" disabled selected>-- Pilih Alat --</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama_alat }} (Sisa: {{ $item->stok_ready }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Input Jumlah --}}
                                        <div class="w-20 flex-shrink-0 relative group/tooltip">
                                            <input type="number" name="items[0][amount]" value="1" min="1" class="block w-full text-center text-sm font-bold text-gray-700 border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 transition" required>
                                            <div class="absolute inset-y-0 right-0 pr-1 flex items-center pointer-events-none text-[10px] text-gray-400">Pcs</div>
                                            
                                            {{-- Tooltip Kanan --}}
                                            <div class="absolute bottom-full right-0 mb-2 hidden group-hover/tooltip:block w-32 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-right">
                                                Sesuaikan stok.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="mt-4 flex gap-3">
                                <button type="button" id="add-item-btn" class="flex-1 py-2.5 border-2 border-dashed border-pink-300 rounded-xl text-pink-500 text-sm font-bold hover:bg-pink-50 hover:border-lab-pink-btn transition duration-300 flex items-center justify-center gap-2 group">
                                    <div class="bg-pink-100 rounded-full p-0.5 group-hover:bg-lab-pink-btn group-hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <span>Tambah Barang</span>
                                </button>

                                <button type="submit" class="flex-1 bg-lab-text text-white text-sm font-bold py-2.5 rounded-xl hover:bg-lab-pink-btn hover:shadow-lg transition transform duration-200 flex justify-center items-center gap-2 shadow-md hover:-translate-y-0.5">
                                    Ajukan Sekarang
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animasi Masuk */
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-enter { animation: slideInUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

    /* Animasi Keluar */
    @keyframes collapseOut {
        0% { opacity: 1; transform: scale(1); max-height: 80px; margin-bottom: 0.75rem; }
        50% { opacity: 0; transform: scale(0.98); }
        100% { opacity: 0; transform: scale(0.95); max-height: 0; margin-bottom: 0; padding: 0; border: none; }
    }
    .animate-remove { animation: collapseOut 0.35s ease-in-out forwards; overflow: hidden; pointer-events: none; }

    /* Panah Tooltip */
    .tooltip-arrow-left::after { content: ""; position: absolute; top: 100%; left: 15px; border-width: 5px; border-style: solid; border-color: #1f2937 transparent transparent transparent; }
    .tooltip-arrow-right::after { content: ""; position: absolute; top: 100%; right: 15px; border-width: 5px; border-style: solid; border-color: #1f2937 transparent transparent transparent; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-item-btn');
        const warningText = document.getElementById('max-items-warning'); // Element pesan peringatan
        const maxItems = 5;
        let itemCount = 1; 

        addBtn.addEventListener('click', function() {
            if (itemCount >= maxItems) {
                // Efek visual jika sudah max (shake)
                addBtn.classList.add('animate-pulse', 'border-red-400', 'text-red-500');
                setTimeout(() => addBtn.classList.remove('animate-pulse', 'border-red-400', 'text-red-500'), 500);
                return;
            }

            let currentIndex = itemCount; 
            itemCount++;

            const newDiv = document.createElement('div');
            newDiv.classList.add('item-row', 'bg-white', 'border', 'border-gray-200', 'rounded-xl', 'p-3', 'shadow-sm', 'relative', 'group', 'animate-enter', 'hover:border-pink-200', 'hover:shadow-md', 'hover:z-50', 'transition-all', 'duration-300', 'z-10');
            
            newDiv.innerHTML = `
                <div class="flex gap-3 items-center">
                    <div class="flex-shrink-0 w-6 h-6 bg-gray-100 text-gray-500 text-xs font-bold rounded-lg flex items-center justify-center index-badge group-hover:bg-lab-pink-btn group-hover:text-white transition">${itemCount}</div>

                    <div class="flex-grow">
                        <select name="items[${currentIndex}][item_id]" class="block w-full text-sm border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 bg-transparent cursor-pointer hover:bg-gray-50 transition" required>
                            <option value="" disabled selected>-- Pilih Alat --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_alat }} (Sisa: {{ $item->stok_ready }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-20 flex-shrink-0 relative group/tooltip">
                        <input type="number" name="items[${currentIndex}][amount]" value="1" min="1" class="block w-full text-center text-sm font-bold text-gray-700 border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 transition" required>
                        <div class="absolute inset-y-0 right-0 pr-1 flex items-center pointer-events-none text-[10px] text-gray-400">Pcs</div>
                        
                        {{-- Tooltip Kanan --}}
                        <div class="absolute bottom-full right-0 mb-2 hidden group-hover/tooltip:block w-32 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-right">
                            Sesuaikan stok.
                        </div>
                    </div>

                    {{-- TOMBOL HAPUS --}}
                    <div class="relative group/delete">
                        <button type="button" class="remove-btn text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg p-1.5 transition duration-200">
                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        
                        <div class="absolute bottom-full right-0 mb-2 hidden group-hover/delete:block w-max bg-gray-800 text-white text-[10px] font-bold py-1 px-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-right">
                            Batal
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(newDiv);
            
            // Cek jika sudah maksimal, sembunyikan tombol tambah dan munculkan peringatan
            if (itemCount >= maxItems) {
                addBtn.classList.add('hidden');
                warningText.classList.remove('hidden'); // Munculkan teks peringatan di bawah Keperluan
            }
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-btn')) {
                const row = e.target.closest('.item-row');
                row.classList.remove('animate-enter');
                row.classList.add('animate-remove');
                
                setTimeout(() => {
                    row.remove();
                    itemCount--;
                    
                    // Kembalikan tombol tambah dan sembunyikan peringatan
                    addBtn.classList.remove('hidden'); 
                    warningText.classList.add('hidden'); // Sembunyikan teks peringatan

                    const badges = container.querySelectorAll('.index-badge');
                    badges.forEach((badge, index) => {
                        badge.innerText = index + 1;
                    });
                }, 350); 
            }
        });
    });
</script>
@endsection