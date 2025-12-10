{{-- Memberitahu file ini untuk menggunakan kerangka dari layouts.app --}}
@extends('layouts.app')

{{-- Memasukkan konten ini ke "lubang" @yield('content') di layout --}}
@section('content')

    {{-- HEADER KONTEN --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold text-lab-text">
            Daftar Inventaris Barang
        </h2>
        
        {{-- Tombol Tambah Data (Memicu Modal) --}}
        <button onclick="openModal('addModal')" class="inline-flex items-center px-4 py-2 bg-lab-pink-btn border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 active:bg-pink-800 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 transition ease-in-out duration-150">
            + Tambah Barang Baru
        </button>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-200">
                
                <thead class="bg-lab-pink">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-lab-text uppercase tracking-wider w-12">
                            No
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-lab-text uppercase tracking-wider">
                            Nama Barang
                        </th>
                        {{-- KOLOM BARU: KODE --}}
                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-lab-text uppercase tracking-wider">
                            Kode
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-bold text-lab-text uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-lab-text uppercase tracking-wider">
                            Total
                        </th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-lab-text uppercase tracking-wider">
                            Sedang Dipinjam
                        </th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-bold text-lab-text uppercase tracking-wider">
                            Ket.
                        </th>
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">

                    {{-- CONTOH DATA 1 --}}
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            1
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">Proyektor Epson X500</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                INV-2023-001
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            Lemari A - Rak 2
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">
                            10
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-bold text-red-600">
                            2
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                            {{-- Button Ubah dengan parameter lengkap (termasuk kode) --}}
                            <button onclick="openEditModal('Proyektor Epson X500', 'INV-2023-001', 'Lemari A - Rak 2', 10, 2)" class="text-white bg-lab-pink-btn hover:bg-pink-700 px-3 py-1 rounded-md text-xs transition-colors">
                                Ubah
                            </button>
                            <button class="text-red-600 hover:text-red-900 ml-2 text-xs font-bold">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    {{-- CONTOH DATA 2 --}}
                    <tr>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            2
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">Kabel HDMI 5m</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                INV-2023-002
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            Box Kabel - Meja Admin
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-bold text-gray-900">
                            5
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-bold text-red-600">
                            0
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick="openEditModal('Kabel HDMI 5m', 'INV-2023-002', 'Box Kabel - Meja Admin', 5, 0)" class="text-white bg-lab-pink-btn hover:bg-pink-700 px-3 py-1 rounded-md text-xs transition-colors">
                                Ubah
                            </button>
                            <button class="text-red-600 hover:text-red-900 ml-2 text-xs font-bold">
                                Hapus
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH DATA --}}
    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background Overlay --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('addModal')"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-lab-text mb-4" id="modal-title">Tambah Barang Baru</h3>
                    
                    <form>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="Contoh: Mouse Logitech">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kode Barang</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="Contoh: INV-001">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi / Lokasi</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="Lokasi atau spesifikasi singkat"></textarea>
                        </div>
                        <div class="flex gap-4">
                            <div class="mb-4 w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Total</label>
                                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                            </div>
                            <div class="mb-4 w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Sedang Dipinjam</label>
                                <input type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="0">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-lab-pink-btn text-base font-medium text-white hover:bg-pink-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan
                    </button>
                    <button type="button" onclick="closeModal('addModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL UBAH DATA --}}
    <div id="editModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('editModal')"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-lab-text mb-4">Ubah Data Barang</h3>
                    
                    <form>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Barang</label>
                            <input type="text" id="edit_nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Kode Barang</label>
                            <input type="text" id="edit_kode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi / Lokasi</label>
                            <textarea id="edit_deskripsi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
                        </div>
                        <div class="flex gap-4">
                            <div class="mb-4 w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah Total</label>
                                <input type="number" id="edit_total" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500">
                            </div>
                            <div class="mb-4 w-1/2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Sedang Dipinjam</label>
                                <input type="number" id="edit_dipinjam" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-pink-500">
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 bg-green-50 p-2 rounded">
                            * Stok Tersedia akan otomatis terhitung (Total - Dipinjam)
                        </div>
                    </form>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-lab-pink-btn text-base font-medium text-white hover:bg-pink-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Perbarui
                    </button>
                    <button type="button" onclick="closeModal('editModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK MODAL --}}
    <script>
        function openModal(modalID) {
            document.getElementById(modalID).classList.remove('hidden');
        }

        function closeModal(modalID) {
            document.getElementById(modalID).classList.add('hidden');
        }

        // Fungsi khusus untuk mengisi form edit saat tombol Ubah diklik
        // Parameter: nama, kode, deskripsi, total, dipinjam
        function openEditModal(nama, kode, deskripsi, total, dipinjam) {
            // Isi value input dengan data dari parameter
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_kode').value = kode;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_total').value = total;
            document.getElementById('edit_dipinjam').value = dipinjam; 
            
            // Buka modal
            openModal('editModal');
        }
    </script>

@endsection