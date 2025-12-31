@extends('layouts.app')

@section('content')
{{-- Config Tailwind Inline --}}
<script>
    if (typeof tailwind !== 'undefined') {
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'lab-pink-btn': '#db2777',
                        'lab-text': '#1f2937',
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    }
</script>

<div class="container mx-auto max-w-6xl px-4 py-6">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('peminjaman') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-lab-pink-btn mb-6 transition duration-300 group">
        <div class="bg-white p-1.5 rounded-full shadow-sm group-hover:shadow-md mr-2 transition">
            <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </div>
        Kembali ke Data Peminjaman
    </a>

    <div class="relative bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 animate-fade-in-up">
        
        {{-- HEADER PINK GRADIENT --}}
        <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn p-6 text-white flex justify-between items-center relative z-10">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
            
            <div>
                <h2 class="text-2xl font-bold tracking-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-pink-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Input Peminjaman Baru
                </h2>
                <p class="text-pink-100 text-sm mt-1 ml-8 opacity-90">Catat peminjaman manual atas nama mahasiswa atau dosen.</p>
            </div>
            
            <div class="hidden md:block relative z-10">
                <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold uppercase tracking-wider rounded-full border border-white/30 backdrop-blur-sm">
                    Admin Mode
                </span>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ route('peminjaman.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="w-full lg:w-1/3 space-y-6">
                        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100 shadow-sm relative group focus-within:ring-2 focus-within:ring-blue-200 transition-all">
                            <h3 class="text-sm font-bold text-blue-800 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                1. Data Peminjam
                            </h3>

                            <div class="relative">
                                <label class="text-[11px] font-bold text-blue-600 uppercase tracking-wide mb-1.5 block">Cari Nama / NIM</label>
                                <input type="hidden" name="user_id" id="user_id_input" required>

                                <div class="relative">
                                    <input type="text" id="user_search" 
                                        class="block w-full text-sm pl-4 pr-10 py-3 bg-white border border-blue-200 rounded-xl focus:outline-none focus:border-blue-400 focus:shadow-sm transition placeholder-gray-400" 
                                        placeholder="Ketik nama mahasiswa..." autocomplete="off">
                                    
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-blue-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                </div>
                                
                                <ul id="user_suggestions" class="absolute z-50 w-full bg-white border border-gray-100 rounded-xl shadow-xl mt-2 max-h-60 overflow-y-auto hidden"></ul>
                            </div>
                            @error('user_id') 
                                <p class="text-red-500 text-xs font-bold mt-2 flex items-center animate-pulse">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Wajib memilih user dari daftar.
                                </p> 
                            @enderror
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200">
                            <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                2. Detail Peminjaman
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Mulai Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" id="start_date" class="block w-full text-sm px-3 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition" required value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Rencana Kembali</label>
                                    <input type="date" name="tanggal_kembali" id="end_date" class="block w-full text-sm px-3 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent outline-none transition" required min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Keperluan / Kegiatan</label>
                                <textarea name="alasan" rows="3" class="block w-full text-sm px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lab-pink-btn focus:border-transparent resize-none bg-white transition" placeholder="Contoh: Praktikum Jaringan, Penelitian Skripsi..." required></textarea>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
                            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                3. Dokumen Pendukung
                            </h3>
                            
                            <div class="bg-gray-100 p-1 rounded-xl flex shadow-inner mb-3">
                                <button type="button" id="btn-auto" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all duration-300 bg-white text-lab-pink-btn shadow-sm flex items-center justify-center gap-1 border border-gray-200">
                                    Surat Otomatis
                                </button>
                                <button type="button" id="btn-upload" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all duration-300 text-gray-500 hover:text-gray-700 flex items-center justify-center gap-1">
                                    Upload Manual
                                </button>
                            </div>

                            <div id="upload-area" class="hidden bg-gray-50 rounded-lg p-4 border border-dashed border-gray-300 animate-enter">
                                <input type="file" name="file_surat" id="file_surat_input" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-lab-pink-btn file:text-white hover:file:bg-pink-700 cursor-pointer transition-colors" accept=".pdf,.doc,.docx" disabled>
                                <p class="text-[10px] text-gray-400 mt-2 text-center">Mendukung PDF/Word (Max 2MB)</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-2/3">
                        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 h-full flex flex-col">
                            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                                <h3 class="font-bold text-gray-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-lab-pink-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Daftar Barang yang Dipinjam
                                </h3>
                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-1 rounded-full font-bold">Stok Realtime</span>
                            </div>
                            <div id="items-container" class="space-y-4 flex-grow">
                                <div class="item-row bg-gray-50 border border-gray-200 rounded-xl p-4 transition-all duration-300 relative group hover:shadow-md hover:bg-white hover:border-pink-200">
                                    <div class="flex gap-4 items-start">
                                        <div class="flex-shrink-0 w-8 h-8 bg-white border border-gray-200 text-gray-500 font-bold rounded-lg flex items-center justify-center index-badge group-hover:bg-lab-pink-btn group-hover:text-white group-hover:border-lab-pink-btn transition shadow-sm">1</div>
                                        
                                        <div class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div class="md:col-span-2">
                                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Alat</label>
                                                <select name="items[0][item_id]" class="item-select block w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2.5 bg-white cursor-pointer" required>
                                                    <option value="" disabled selected data-stock="0">-- Pilih Alat --</option>
                                                    @foreach($items as $item)
                                                        <option value="{{ $item->id }}" data-stock="{{ $item->jumlah_total ?? 0 }}">
                                                            {{ $item->nama_alat }} (Total: {{ $item->jumlah_total ?? 'N/A' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="relative group/tooltip">
                                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah</label>
                                                <div class="relative">
                                                    <input type="number" name="items[0][amount]" value="1" min="1" class="block w-full text-center text-sm font-bold text-gray-700 border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2.5 transition" required>
                                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-xs text-gray-400 font-medium">Unit</div>
                                                </div>
                                                
                                                <div class="stock-tooltip absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover/tooltip:block w-max bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-50">
                                                    Pilih barang dulu.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="max-items-warning" class="hidden mt-4 p-3 bg-red-50 text-red-600 text-xs font-bold rounded-lg text-center border border-red-100 flex items-center justify-center gap-2 animate-pulse">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Batas maksimal 5 jenis barang tercapai.
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-100 flex gap-4">
                                <button type="button" id="add-item-btn" class="flex-1 py-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 text-sm font-bold hover:bg-gray-50 hover:border-lab-pink-btn hover:text-lab-pink-btn transition duration-300 flex items-center justify-center gap-2 group">
                                    <div class="bg-gray-100 rounded-full p-1 group-hover:bg-lab-pink-btn group-hover:text-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    Tambah Barang Lain
                                </button>
                                
                                <button type="submit" class="flex-1 bg-lab-pink-btn text-white text-sm font-bold py-3 rounded-xl hover:bg-pink-700 hover:shadow-lg transition transform duration-200 flex justify-center items-center gap-2 shadow-md hover:-translate-y-0.5">
                                    <span>Simpan Peminjaman</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .animate-enter { animation: slideInUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    .animate-remove { animation: collapseOut 0.35s ease-in-out forwards; overflow: hidden; pointer-events: none; }
    @keyframes collapseOut { 
        0% { opacity: 1; transform: scale(1); max-height: 100px; margin-bottom: 1rem; } 
        100% { opacity: 0; transform: scale(0.95); max-height: 0; margin-bottom: 0; padding: 0; border: none; } 
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        startDate.addEventListener('change', function() {
            endDate.min = this.value;
            if (endDate.value < this.value) {
                endDate.value = this.value;
            }
        });
        const btnAuto = document.getElementById('btn-auto');
        const btnUpload = document.getElementById('btn-upload');
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('file_surat_input');

        const activeClass = ['bg-white', 'text-lab-pink-btn', 'shadow-sm', 'border-gray-200'];
        const inactiveClass = ['text-gray-500', 'hover:text-gray-700', 'border-transparent'];

        btnAuto.addEventListener('click', function() {
            btnAuto.classList.add(...activeClass);
            btnAuto.classList.remove(...inactiveClass);
            btnUpload.classList.remove(...activeClass);
            btnUpload.classList.add(...inactiveClass);
            uploadArea.classList.add('hidden');
            fileInput.disabled = true; 
            fileInput.value = ''; 
        });

        btnUpload.addEventListener('click', function() {
            btnUpload.classList.add(...activeClass);
            btnUpload.classList.remove(...inactiveClass);
            btnAuto.classList.remove(...activeClass);
            btnAuto.classList.add(...inactiveClass);
            uploadArea.classList.remove('hidden');
            uploadArea.classList.remove('animate-enter');
            void uploadArea.offsetWidth; 
            uploadArea.classList.add('animate-enter');
            fileInput.disabled = false;
        });
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
                    li.className = 'px-4 py-3 hover:bg-pink-50 cursor-pointer border-b border-gray-50 last:border-0 transition-colors flex justify-between items-center group';
                    const userNim = user.identity_number || user.nim || '-';
                    const userRole = user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : '-';

                    li.innerHTML = `
                        <div>
                            <div class="font-bold text-gray-800 text-sm group-hover:text-lab-pink-btn transition">${user.name}</div>
                            <div class="text-xs text-gray-400">${user.email || ''}</div>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full font-mono font-bold block mb-1">${userNim}</span>
                            <span class="text-[9px] text-blue-500 font-bold uppercase tracking-wide">${userRole}</span>
                        </div>
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
        const maxItems = 5; 
        let itemCount = 1; 

        function updateStockConstraints(row) {
            const select = row.querySelector('select');
            const input = row.querySelector('input[type="number"]');
            const tooltip = row.querySelector('.stock-tooltip');
            
            const selectedOption = select.options[select.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            input.max = stock;
            
            if (parseInt(input.value) > stock) {
                input.value = stock;
                input.classList.add('border-red-500', 'text-red-600');
                setTimeout(() => input.classList.remove('border-red-500', 'text-red-600'), 500);
            }
            
            if (stock > 0) {
                tooltip.innerText = `Sisa Stok: ${stock} Unit`;
            } else {
                tooltip.innerText = "Stok Kosong / Tidak Dipilih";
                input.value = 0;
            }
        }

        container.addEventListener('input', function(e) {
             if (e.target.type === 'number') {
                const max = parseInt(e.target.max);
                const val = parseInt(e.target.value);
                
                if (val > max) {
                    e.target.value = max; // Paksa turun ke max
                    const tooltip = e.target.closest('.group\\/tooltip').querySelector('.stock-tooltip');
                    tooltip.innerText = `Maksimal hanya ${max}!`;
                    tooltip.classList.remove('hidden');
                    setTimeout(() => tooltip.classList.add('hidden'), 2000);
                }
             }
        });
        container.addEventListener('change', function(e) {
            if (e.target.classList.contains('item-select')) {
                const row = e.target.closest('.item-row');
                updateStockConstraints(row);
            }
        });
        addBtn.addEventListener('click', function() {
            if (itemCount >= maxItems) {
                addBtn.classList.add('opacity-50', 'cursor-not-allowed');
                warningText.classList.remove('hidden');
                return;
            }

            let currentIndex = itemCount; 
            itemCount++;

            const newDiv = document.createElement('div');
            newDiv.className = 'item-row bg-gray-50 border border-gray-200 rounded-xl p-4 transition-all duration-300 relative group hover:shadow-md hover:bg-white hover:border-pink-200 animate-enter';
            
            newDiv.innerHTML = `
                <div class="flex gap-4 items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-white border border-gray-200 text-gray-500 font-bold rounded-lg flex items-center justify-center index-badge group-hover:bg-lab-pink-btn group-hover:text-white group-hover:border-lab-pink-btn transition shadow-sm">${itemCount}</div>
                    
                    <div class="flex-grow grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Alat</label>
                            <select name="items[${currentIndex}][item_id]" class="item-select block w-full text-sm border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2.5 bg-white cursor-pointer" required>
                                <option value="" disabled selected data-stock="0">-- Pilih Alat --</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" data-stock="{{ $item->jumlah_total ?? 0 }}">
                                        {{ $item->nama_alat }} (Total: {{ $item->jumlah_total ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="relative group/tooltip">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Jumlah</label>
                            <div class="relative">
                                <input type="number" name="items[${currentIndex}][amount]" value="1" min="1" class="block w-full text-center text-sm font-bold text-gray-700 border-gray-300 rounded-lg focus:ring-lab-pink-btn focus:border-lab-pink-btn py-2.5 transition" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-xs text-gray-400 font-medium">Unit</div>
                            </div>
                            <div class="stock-tooltip absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover/tooltip:block w-max bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-50">
                                Pilih barang dulu.
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="remove-btn absolute -top-2 -right-2 bg-white text-gray-300 border border-gray-200 shadow-sm hover:text-red-500 hover:border-red-200 hover:shadow-md rounded-full p-1.5 transition duration-200 opacity-0 group-hover:opacity-100">
                        <svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;

            container.appendChild(newDiv);
            
            if (itemCount >= maxItems) {
                addBtn.classList.add('opacity-50', 'cursor-not-allowed');
                warningText.classList.remove('hidden');
            }
        });

        // Hapus Item
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-btn')) {
                const row = e.target.closest('.item-row');
                row.classList.remove('animate-enter');
                row.classList.add('animate-remove');
                
                setTimeout(() => {
                    row.remove();
                    itemCount--;
                    
                    if (itemCount < maxItems) {
                        addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        warningText.classList.add('hidden');
                    }
                    
                    const badges = container.querySelectorAll('.index-badge');
                    badges.forEach((badge, index) => { badge.innerText = index + 1; });
                    
                    const rows = container.querySelectorAll('.item-row');
                    rows.forEach((rowElem, idx) => {
                        const select = rowElem.querySelector('select');
                        const input = rowElem.querySelector('input[type="number"]');
                        select.name = `items[${idx}][item_id]`;
                        input.name = `items[${idx}][amount]`;
                    });

                }, 350); 
            }
        });
    });
</script>
@endsection