@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    
   <div class="bg-gradient-to-r from-pink-900 to-pink-600 rounded-2xl p-6 md:p-8 mb-6 text-white shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="w-full md:flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold">Daftar Anggota Laboratorium</h1>
                <p class="mt-1 text-pink-100 opacity-90">Kelola semua data mahasiswa dan dosen disini.</p>
            </div>
        
            <div class="w-full md:w-auto flex justify-center md:justify-end">
                <a href="{{ route('members.create') }}" 
                   class="inline-flex items-center bg-white text-pink-700 font-bold px-5 py-3 rounded-xl shadow-lg hover:bg-pink-50 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Anggota Baru
                </a>    
            </div>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-2 mb-6 px-1">
        <button type="button" class="px-4 py-1.5 text-sm font-bold bg-pink-100 text-pink-700 border border-pink-200 rounded-full shadow-sm hover:bg-pink-200 transition">
            Semua
        </button>
        <button type="button" class="px-4 py-1.5 text-sm font-medium bg-white text-gray-600 border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 transition">
            Mahasiswa
        </button>
        <button type="button" class="px-4 py-1.5 text-sm font-medium bg-white text-gray-600 border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 transition">
            Dosen
        </button>
    </div>

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
                    @forelse($members as $index => $member)
                    <tr class="hover:bg-pink-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <img class="h-8 w-8 rounded-full bg-gray-200" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" 
                                         alt="{{ $member->name }}">
                                </div>

                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->name }}</div>
                                    <div class="text-xs text-gray-400">Bergabung: {{ $member->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                            @if($member->identity_number)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ $member->identity_number }}
                                </span>
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $member->contact ?? '-' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $member->email }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('members.edit', $member->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition">Edit</a>
                            
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus anggota ini? Data yang dihapus tidak bisa dikembalikan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1 rounded-md transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty

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