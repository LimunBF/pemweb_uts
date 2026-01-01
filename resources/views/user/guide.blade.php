@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-6xl pb-24">

    {{-- HEADER SECTION --}}
    <div class="relative bg-white rounded-3xl p-8 md:p-12 mb-10 overflow-hidden shadow-sm border border-gray-100 text-center md:text-left">
        {{-- Dekorasi Background --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-pink-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -translate-y-10 translate-x-10 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 translate-y-10 -translate-x-10 animate-pulse" style="animation-delay: 1s"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-lab-text tracking-tight mb-4">
                    Pusat Bantuan & <span class="text-transparent bg-clip-text bg-gradient-to-r from-lab-pink-btn to-purple-600">Panduan</span>
                </h1>
                <p class="text-gray-500 text-lg max-w-xl leading-relaxed">
                    Pelajari cara meminjam alat, pahami aturan peminjamannya, dan temukan jawaban atas pertanyaanmu di sini.
                </p>
            </div>
            {{-- Icon Dekoratif Besar --}}
            <div class="hidden md:block transform rotate-12 hover:rotate-0 transition duration-500">
                <div class="w-32 h-32 bg-gradient-to-br from-lab-pink-btn to-purple-600 rounded-3xl flex items-center justify-center shadow-xl shadow-pink-200 text-white">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        {{-- SIDEBAR KIRI (STICKY) - 4 Kolom --}}
        <div class="lg:col-span-4 lg:sticky lg:top-8 space-y-6">
            
            {{-- Card Navigasi Tab --}}
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                <div class="p-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700">Menu Navigasi</h3>
                </div>
                <div class="p-2 space-y-1">
                    <button onclick="switchTab('alur')" id="btn-alur" class="tab-btn w-full flex items-center p-3 rounded-xl text-left transition-all duration-300 bg-pink-50 text-lab-pink-btn font-bold">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        Alur Peminjaman
                    </button>
                    
                    <button onclick="switchTab('aturan')" id="btn-aturan" class="tab-btn w-full flex items-center p-3 rounded-xl text-left transition-all duration-300 hover:bg-gray-50 text-gray-600 font-medium hover:text-gray-900">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        Aturan & Sanksi
                    </button>

                    <button onclick="switchTab('faq')" id="btn-faq" class="tab-btn w-full flex items-center p-3 rounded-xl text-left transition-all duration-300 hover:bg-gray-50 text-gray-600 font-medium hover:text-gray-900">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        FAQ (Tanya Jawab)
                    </button>
                </div>
            </div>

            {{-- Card Kontak --}}
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-2">Butuh Bantuan Mendesak?</h3>
                    <p class="text-gray-400 text-sm mb-4">Laboran kami siap membantu pada jam kerja (Senin-Jumat, 08.00 - 16.00).</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center justify-center w-full py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl transition font-bold shadow-lg transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        Chat via WhatsApp
                    </a>
                </div>
                {{-- Lingkaran Dekorasi --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            </div>
        </div>

        {{-- KONTEN KANAN (DYNAMIC TABS) - 8 Kolom --}}
        <div class="lg:col-span-8">
            
            {{-- TAB 1: ALUR PEMINJAMAN --}}
            <div id="tab-alur" class="tab-content transition-opacity duration-300">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 border-b border-gray-100 pb-4">Timeline Peminjaman</h2>
                    
                    <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-gray-200 before:to-transparent">
                        
                        {{-- STEP 1 --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-100 group-[.is-active]:bg-lab-pink-btn group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 font-bold text-sm">
                                1
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="font-bold text-gray-800 mb-1">Cek & Ajukan</div>
                                <div class="text-gray-500 text-sm">Cek ketersediaan di menu Inventaris. Jika ada, isi form peminjaman dengan lengkap.</div>
                            </div>
                        </div>

                        {{-- STEP 2 --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-100 group-[.is-active]:bg-lab-pink-btn group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 font-bold text-sm">
                                2
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="font-bold text-gray-800 mb-1">Cetak Surat</div>
                                <div class="text-gray-500 text-sm">Masuk menu "Riwayat". Klik tombol <strong>Unduh Surat</strong>. Print surat tersebut.</div>
                            </div>
                        </div>

                        {{-- STEP 3 --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-100 group-[.is-active]:bg-lab-pink-btn group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 font-bold text-sm">
                                3
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="font-bold text-gray-800 mb-1">Tanda Tangan</div>
                                <div class="text-gray-500 text-sm">Tanda tangani surat tersebut (TTD Basah). Ini bukti fisik wajib.</div>
                            </div>
                        </div>

                        {{-- STEP 4 --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-100 group-[.is-active]:bg-purple-600 group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 font-bold text-sm">
                                4
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-purple-50 p-5 rounded-2xl border border-purple-100 shadow-sm">
                                <div class="font-bold text-purple-800 mb-1">Ambil Barang</div>
                                <div class="text-purple-600 text-sm">Bawa surat ke Laboratorium. Admin akan validasi dan serahkan barang.</div>
                            </div>
                        </div>

                        {{-- STEP 5 --}}
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-gray-100 group-[.is-active]:bg-green-600 group-[.is-active]:text-white shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10 font-bold text-sm">
                                5
                            </div>
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="font-bold text-gray-800 mb-1">Kembalikan</div>
                                <div class="text-gray-500 text-sm">Kembalikan tepat waktu. Kondisi barang akan dicek sebelum status "Selesai".</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- TAB 2: ATURAN & SANKSI --}}
            <div id="tab-aturan" class="tab-content hidden transition-opacity duration-300">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 border-b border-gray-100 pb-4">Peraturan & Konsekuensi</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Card Denda --}}
                        <div class="bg-red-50 rounded-2xl p-6 border border-red-100 hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-4 text-red-500 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-red-800 mb-2">Keterlambatan</h3>
                            <p class="text-sm text-red-600 leading-relaxed">
                                Pengembalian melewati batas waktu akan dikenakan sanksi <strong>Blacklist Sementara</strong> (Tidak boleh meminjam) selama 2 minggu.
                            </p>
                        </div>

                        {{-- Card Kerusakan --}}
                        <div class="bg-orange-50 rounded-2xl p-6 border border-orange-100 hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-4 text-orange-500 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-orange-800 mb-2">Kerusakan / Hilang</h3>
                            <p class="text-sm text-orange-700 leading-relaxed">
                                Peminjam wajib mengganti barang yang rusak/hilang dengan <strong>barang sejenis</strong> atau biaya perbaikan resmi.
                            </p>
                        </div>

                         {{-- Card Kebersihan --}}
                         <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mb-4 text-blue-500 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-blue-800 mb-2">Kebersihan</h3>
                            <p class="text-sm text-blue-700 leading-relaxed">
                                Alat wajib dikembalikan dalam kondisi bersih dan kabel tergulung rapi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 3: FAQ --}}
            <div id="tab-faq" class="tab-content hidden transition-opacity duration-300">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8 border-b border-gray-100 pb-4">Tanya Jawab (FAQ)</h2>
                    
                    <div class="space-y-4">
                        {{-- FAQ ITEM 1 --}}
                        <div class="border border-gray-200 rounded-xl p-5 hover:border-lab-pink-btn transition-colors cursor-pointer group" onclick="toggleAccordion(this)">
                            <div class="flex justify-between items-center">
                                <h4 class="font-bold text-gray-700 group-hover:text-lab-pink-btn">Berapa lama maksimal peminjaman?</h4>
                                <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <div class="faq-content hidden mt-3 text-sm text-gray-600 leading-relaxed">
                                Maksimal peminjaman adalah <strong>1 Minggu</strong>. Jika butuh lebih lama, silakan hubungi Laboran untuk perpanjangan khusus dengan alasan yang jelas.
                            </div>
                        </div>

                        {{-- FAQ ITEM 2 --}}
                        <div class="border border-gray-200 rounded-xl p-5 hover:border-lab-pink-btn transition-colors cursor-pointer group" onclick="toggleAccordion(this)">
                            <div class="flex justify-between items-center">
                                <h4 class="font-bold text-gray-700 group-hover:text-lab-pink-btn">Apakah bisa meminjam di hari libur?</h4>
                                <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <div class="faq-content hidden mt-3 text-sm text-gray-600 leading-relaxed">
                                Tidak dapat diproses. Layanan pengambilan dan pengembalian barang hanya tersedia pada <strong>Hari Kerja (Senin–Jumat)</strong> pukul 08.00–16.00 WIB. Apabila terdapat kebutuhan mendesak, silakan menghubungi Laboran untuk pengaturan janji khusus.
                            </div>
                        </div>

                        {{-- FAQ ITEM 3 --}}
                        <div class="border border-gray-200 rounded-xl p-5 hover:border-lab-pink-btn transition-colors cursor-pointer group" onclick="toggleAccordion(this)">
                            <div class="flex justify-between items-center">
                                <h4 class="font-bold text-gray-700 group-hover:text-lab-pink-btn">Bagaimana jika saya menghilangkan surat?</h4>
                                <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            <div class="faq-content hidden mt-3 text-sm text-gray-600 leading-relaxed">
                                Tenang saja. Anda bisa mendownload ulang surat peminjaman kapan saja melalui menu <strong>Riwayat Peminjaman</strong> di dashboard website ini.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // 1. Sembunyikan semua tab content
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('animate-fade-in-up');
        });

        // 2. Reset style semua tombol
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-pink-50', 'text-lab-pink-btn', 'font-bold');
            btn.classList.add('text-gray-600', 'hover:bg-gray-50');
        });

        // 3. Tampilkan tab yang dipilih
        const targetTab = document.getElementById('tab-' + tabId);
        targetTab.classList.remove('hidden');
        targetTab.classList.add('animate-fade-in-up'); // Tambahkan animasi

        // 4. Highlight tombol yang aktif
        const activeBtn = document.getElementById('btn-' + tabId);
        activeBtn.classList.remove('text-gray-600', 'hover:bg-gray-50');
        activeBtn.classList.add('bg-pink-50', 'text-lab-pink-btn', 'font-bold');
    }

    function toggleAccordion(element) {
        const content = element.querySelector('.faq-content');
        const icon = element.querySelector('svg');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>

<style>
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
</style>
@endsection