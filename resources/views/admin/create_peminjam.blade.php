@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl px-4 py-4">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('peminjaman') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-lab-pink-btn mb-4 transition duration-300 group">
        <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Data Peminjaman
    </a>

    <div class="relative bg-gradient-to-br from-pink-100 via-pink-50 to-white rounded-3xl p-1.5 shadow-lg">
        <div class="bg-white rounded-2xl shadow-inner relative z-0">
            
            {{-- Header --}}
            <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-5 text-white flex justify-between items-center relative rounded-t-2xl">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Catat Peminjaman (Admin)</h2>
                    <p class="text-pink-100 text-xs mt-1 flex items-center opacity-90">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Admin mencatat peminjaman untuk mahasiswa.
                    </p>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="flex flex-col lg:flex-row gap-6">
                        
                        <div class="w-full lg:w-1/3 space-y-4">
                            
                            {{-- 1. PENCARIAN MAHASISWA (Pengganti Upload Surat) --}}
                            <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100 relative z-30">
                                <h3 class="text-sm font-bold text-blue-800 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Data Peminjam
                                </h3>

                                <div class="relative">
                                    <label for="user_search" class="text-xs font-semibold text-gray-500 mb-1 block">Cari Nama atau NIM</label>
                                    <input type="hidden" name="user_id" id="user_id_input" required>

                                    <div class="relative">
                                        <input type="text" id="user_search" 
                                            class="block w-full text-sm pl-3 pr-8 py-2 bg-white border border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn outline-none transition" 
                                            placeholder="Ketik Nama / NIM..." autocomplete="off">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                    </div>
                                    
                                    
                                    <ul id="user_suggestions" class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-xl mt-1 max-h-60 overflow-y-auto hidden">
                                    </ul>
                                </div>
                                <p class="text-[10px] text-blue-600 mt-2 leading-tight">
                                    Pastikan memilih mahasiswa dari daftar yang muncul.
                                </p>
                                @error('user_id') <span class="text-red-500 text-[10px] font-bold block mt-1">Data mahasiswa wajib dipilih.</span> @enderror
                            </div>

                            {{-- 2. TANGGAL --}}
                            <div class="bg-pink-50/50 rounded-xl p-4 border border-pink-100 relative z-20">
                                <h3 class="text-sm font-bold text-lab-text mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Detail Waktu
                                </h3>
                                
                                <div class="mb-3">
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_pinjam" class="block w-full text-sm px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn outline-none transition" required value="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1">Rencana Kembali</label>
                                    <input type="date" name="tanggal_kembali" class="block w-full text-sm px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn outline-none transition" required min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            {{-- 3. ALASAN --}}
                            <div class="relative z-10">
                                <label class="block text-xs font-bold text-gray-500 mb-1 ml-1">Keperluan / Kegiatan</label>
                                <textarea name="alasan" rows="3" class="block w-full text-sm px-3 py-2 border border-gray-200 rounded-xl focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn resize-none bg-gray-50 focus:bg-white transition" placeholder="Contoh: Praktikum Jaringan Komputer..."></textarea>
                            </div>
                        </div>

                        {{-- KANAN: Daftar Barang (Multi Item) --}}
                        <div class="w-full lg:w-2/3">
                            <div class="flex justify-between items-end mb-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Item Peminjaman</label>
                                <span class="text-[10px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">Admin Mode</span>
                            </div>
                            
                            <div id="items-container" class="space-y-3 pb-2">
                                <div class="item-row bg-white border border-gray-200 rounded-xl p-3 shadow-sm hover:border-pink-200 hover:shadow-md hover:z-50 transition-all duration-300 relative group z-10">
                                    <div class="flex gap-3 items-center">
                                        <div class="flex-shrink-0 w-6 h-6 bg-gray-100 text-gray-500 text-xs font-bold rounded-lg flex items-center justify-center index-badge group-hover:bg-lab-pink-btn group-hover:text-white transition">1</div>
                                        <div class="flex-grow">
                                            <select name="items[0][item_id]" class="item-select block w-full text-sm border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 bg-transparent cursor-pointer hover:bg-gray-50 transition" required>
                                                <option value="" disabled selected data-stock="0">-- Pilih Alat --</option>
                                                @foreach($items as $item)
                                                    <option value="{{ $item->id }}" data-stock="{{ $item->jumlah_total ?? 0 }}">
                                                        {{ $item->nama_alat }} (Total: {{ $item->jumlah_total ?? 'N/A' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="w-20 flex-shrink-0 relative group/tooltip">
                                            <input type="number" name="items[0][amount]" value="1" min="1" class="block w-full text-center text-sm font-bold text-gray-700 border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 transition" required>
                                            <div class="absolute inset-y-0 right-0 pr-1 flex items-center pointer-events-none text-[10px] text-gray-400">Pcs</div>

                                            <div class="stock-tooltip absolute bottom-full right-0 mb-2 hidden group-hover/tooltip:block w-max bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-right">
                                                Pilih barang dulu.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 flex gap-3">
                                <button type="button" id="add-item-btn" class="flex-1 py-2.5 border-2 border-dashed border-pink-300 rounded-xl text-pink-500 text-sm font-bold hover:bg-pink-50 hover:border-lab-pink-btn transition duration-300 flex items-center justify-center gap-2 group">
                                    <div class="bg-pink-100 rounded-full p-0.5 group-hover:bg-lab-pink-btn group-hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <span>Tambah Barang Lain</span>
                                </button>
                                <button type="submit" class="flex-1 bg-lab-text text-white text-sm font-bold py-2.5 rounded-xl hover:bg-lab-pink-btn hover:shadow-lg transition transform duration-200 flex justify-center items-center gap-2 shadow-md hover:-translate-y-0.5">
                                    <span>Simpan Data</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </div>
                            
                            <p id="max-items-warning" class="hidden text-[10px] text-red-500 font-bold mt-2 text-center animate-pulse">
                                Batas maksimal input barang tercapai.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>

    /* CSS GLOBAL */
    html { overflow-y: scroll; }
    @keyframes slideInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-enter { animation: slideInUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes collapseOut { 0% { opacity: 1; transform: scale(1); max-height: 80px; margin-bottom: 0.75rem; } 50% { opacity: 0; transform: scale(0.98); } 100% { opacity: 0; transform: scale(0.95); max-height: 0; margin-bottom: 0; padding: 0; border: none; } }
    .animate-remove { animation: collapseOut 0.35s ease-in-out forwards; overflow: hidden; pointer-events: none; }
    .tooltip-arrow-right::after { content: ""; position: absolute; top: 100%; right: 15px; border-width: 5px; border-style: solid; border-color: #1f2937 transparent transparent transparent; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const users = @json($users); 
        const searchInput = document.getElementById('user_search');
        const hiddenInput = document.getElementById('user_id_input');
        const suggestionsBox = document.getElementById('user_suggestions');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            suggestionsBox.innerHTML = '';
            hiddenInput.value = ''; 
            
            if (query.length < 1) {
                suggestionsBox.classList.add('hidden');
                return;
            }

            const filteredUsers = users.filter(user => {
                const name = user.name ? user.name.toLowerCase() : '';
                const nim = user.identity_number ? String(user.identity_number).toLowerCase() : 
                           (user.nim ? String(user.nim).toLowerCase() : ''); 
                
                return name.includes(query) || nim.includes(query);
            });

            if (filteredUsers.length > 0) {
                suggestionsBox.classList.remove('hidden');
                filteredUsers.forEach(user => {
                    const li = document.createElement('li');
                    li.className = 'px-4 py-2 hover:bg-pink-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-0';
                    
                    const userNim = user.identity_number || user.nim || '-';

                    li.innerHTML = `
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-800">${user.name}</span>
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full font-mono">${userNim}</span>
                        </div>
                        <span class="text-xs text-gray-400 block mt-0.5">${user.email || ''}</span>
                    `;
                    
                    li.addEventListener('click', () => {
                        searchInput.value = `${user.name} (${userNim})`; 
                        hiddenInput.value = user.id; 
                        suggestionsBox.classList.add('hidden');
                    });

                    suggestionsBox.appendChild(li);
                });
            } else {
                suggestionsBox.classList.remove('hidden');
                suggestionsBox.innerHTML = '<li class="px-4 py-3 text-sm text-gray-500 italic text-center">Data tidak ditemukan.</li>';
            }
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                suggestionsBox.classList.add('hidden');
            }
        });


        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-item-btn');
        const warningText = document.getElementById('max-items-warning'); 
        const maxItems = 10;
        let itemCount = 1; 

        function updateStockTooltip(row) {
            const select = row.querySelector('select');
            const tooltip = row.querySelector('.stock-tooltip');
            const selectedOption = select.options[select.selectedIndex];
            const stock = selectedOption.getAttribute('data-stock');

            if (stock) {
                tooltip.innerText = `Total Unit: ${stock}`;
            } else {
                tooltip.innerText = "Pilih alat dahulu";
            }
        }

        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-select')) {
                const row = e.target.closest('.item-row');
                updateStockTooltip(row);
            }
        });

        addBtn.addEventListener('click', function() {
            if (itemCount >= maxItems) {
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
                        <select name="items[${currentIndex}][item_id]" class="item-select block w-full text-sm border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 bg-transparent cursor-pointer hover:bg-gray-50 transition" required>
                            <option value="" disabled selected data-stock="0">-- Pilih Alat --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" data-stock="{{ $item->jumlah_total ?? 0 }}">
                                    {{ $item->nama_alat }} (Total: {{ $item->jumlah_total ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-20 flex-shrink-0 relative group/tooltip">
                        <input type="number" name="items[${currentIndex}][amount]" value="1" min="1" class="block w-full text-center text-sm font-bold text-gray-700 border-gray-200 rounded-lg focus:ring-1 focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2 transition" required>
                        <div class="absolute inset-y-0 right-0 pr-1 flex items-center pointer-events-none text-[10px] text-gray-400">Pcs</div>
                        <div class="stock-tooltip absolute bottom-full right-0 mb-2 hidden group-hover/tooltip:block w-max bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-[100] animate-enter tooltip-arrow-right">Pilih alat dahulu.</div>
                    </div>
                    <div class="relative group/delete">
                        <button type="button" class="remove-btn text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg p-1.5 transition duration-200">
                            <svg class="w-5 h-5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(newDiv);
            if (itemCount >= maxItems) {
                addBtn.classList.add('hidden');
                warningText.classList.remove('hidden');
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
                    addBtn.classList.remove('hidden'); 
                    warningText.classList.add('hidden');
                    const badges = container.querySelectorAll('.index-badge');
                    badges.forEach((badge, index) => { badge.innerText = index + 1; });
                }, 350); 
            }
        });
    });
</script>
@endsection