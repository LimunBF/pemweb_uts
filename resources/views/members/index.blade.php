@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    
    {{-- Header & Tombol Tambah --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-pink-800">Daftar Anggota</h2>
            <p class="text-md italic text-pink-500 mt-1">Kelola semua data mahasiswa/anggota di sini.</p>
        </div>
        
        {{-- Link tombol bisa disesuaikan, misalnya ke route('members.create') jika sudah ada --}}
        <a href="{{ route('members.create') }}" class="bg-lab-pink-btn hover:bg-pink-700 text-white font-medium py-2 px-4 rounded-lg shadow-md flex items-center transition ease-in-out duration-150">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Tambah Anggota Baru
        </a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
        <div class="flex items-center">
            <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p><strong class="font-bold">Berhasil!</strong> {{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">NIM</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No HP</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Menggunakan variabel $members --}}
                    @forelse($members as $index => $member)
                    <tr class="hover:bg-pink-50 transition duration-150 ease-in-out">
                        {{-- Kolom No --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        
                        {{-- Kolom Nama (DITAMBAHKAN AVATAR) --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                {{-- 1. Bagian Gambar Avatar --}}
                                <div class="flex-shrink-0 h-8 w-8">
                                    {{-- Menggunakan urlencode($member->name) agar inisial sesuai nama --}}
                                    <img class="h-8 w-8 rounded-full bg-gray-200" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" 
                                         alt="{{ $member->name }}">
                                </div>
                                
                                {{-- 2. Bagian Teks Nama --}}
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                    <div class="text-xs text-gray-400">Bergabung: {{ $member->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Kolom NIM --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                            @if($member->identity_number)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ $member->identity_number }}
                                </span>
                            @else
                                -
                            @endif
                        </td>

                        {{-- Kolom No HP --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $member->contact ?? '-' }}
                        </td>

                        {{-- Kolom Email --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $member->email }}
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            {{-- Tombol Edit (Link Dummy #) --}}
                            <a href="{{ route('members.edit', $member->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition">Edit</a>
                            
                            {{-- Form Hapus --}}
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus anggota ini? Data yang dihapus tidak bisa dikembalikan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    {{-- Tampilan Kosong --}}
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                <p class="text-lg font-medium">Belum ada data anggota.</p>
                                <p class="text-sm text-gray-400">Silakan tambahkan anggota baru untuk memulai.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection