@extends('layouts.app')

@section('content')
<div class="container mx-auto font-poppins">
    
   {{-- Header Banner --}}
   <div class="bg-gradient-to-r from-pink-900 to-pink-600 rounded-2xl p-6 md:p-8 mb-6 text-white shadow-lg relative overflow-hidden animate-element">
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="w-full md:flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold">Daftar Anggota Laboratorium</h1>
                <p class="mt-1 text-pink-100 opacity-90">Kelola semua data mahasiswa, dosen, dan admin disini.</p>
            </div>
        
            <div class="w-full md:w-auto flex justify-center md:justify-end">
                <a href="{{ route('members.create') }}" 
                   class="inline-flex items-center bg-white text-pink-700 font-bold px-5 py-3 rounded-xl shadow-lg hover:bg-pink-50 transition ease-in-out duration-150 transform hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Anggota Baru
                </a>    
            </div>
        </div>
    </div>

    {{-- Filter Buttons --}}
    <div class="flex flex-wrap items-center gap-2 mb-6 px-1 animate-element" style="animation-delay: 0.1s;">
        
        {{-- Tombol Semua --}}
        <a href="{{ route('members.index') }}" 
           class="px-5 py-2 text-sm rounded-full shadow-sm border transition duration-200 
           {{ !request('role') 
               ? 'bg-pink-600 text-white border-pink-600 font-bold shadow-pink-200' 
               : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50 font-medium' }}">
            Semua
        </a>

        {{-- Tombol Mahasiswa --}}
        <a href="{{ route('members.index', ['role' => 'mahasiswa']) }}" 
           class="px-5 py-2 text-sm rounded-full shadow-sm border transition duration-200 
           {{ request('role') == 'mahasiswa' 
               ? 'bg-pink-600 text-white border-pink-600 font-bold shadow-pink-200' 
               : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50 font-medium' }}">
            Mahasiswa
        </a>

        {{-- Tombol Dosen --}}
        <a href="{{ route('members.index', ['role' => 'dosen']) }}" 
           class="px-5 py-2 text-sm rounded-full shadow-sm border transition duration-200 
           {{ request('role') == 'dosen' 
               ? 'bg-pink-600 text-white border-pink-600 font-bold shadow-pink-200' 
               : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-50 font-medium' }}">
            Dosen
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm animate-element" role="alert">
        <div class="flex items-center">
            <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p><strong class="font-bold">Berhasil!</strong> {{ session('success') }}</p>
        </div>
    </div>
    @endif

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden animate-element" style="animation-delay: 0.2s;">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-16">No</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Identitas</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kontak & Email</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $index => $member)
                    <tr class="hover:bg-pink-50 transition duration-150 ease-in-out group">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        
                        {{-- 1. Nama & Tanggal Bergabung --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full bg-gray-200 border-2 border-white shadow-sm" 
                                         src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random&color=fff" 
                                         alt="{{ $member->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900 group-hover:text-pink-700 transition">{{ $member->name }}</div>
                                    <div class="text-xs text-gray-400 flex items-center mt-0.5">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $member->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- 3. Role dengan Admin --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($member->role == 'admin')
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                    Admin
                                </span>
                            @elseif($member->role == 'dosen')
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 border border-purple-200">
                                    Dosen
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                    Mahasiswa
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                            {{ $member->identity_number ?? '-' }}
                        </td>

                        {{-- 2. Kontak & Email Digabung --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex flex-col space-y-1.5">
                                {{-- Kontak --}}
                                @if($member->contact)
                                    <div class="flex items-center text-gray-700 font-medium">
                                        <svg class="w-3.5 h-3.5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-8.68-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.151-.174.2-.298.3-.495.099-.198.05-.372-.025-.52-.075-.149-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        {{ $member->contact }}
                                    </div>
                                @else
                                    <span class="text-gray-300 text-xs">-</span>
                                @endif

                                {{-- Email --}}
                                <div class="flex items-center text-gray-500 text-xs">
                                    <svg class="w-3.5 h-3.5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $member->email }}
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('members.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">Edit</a>
                            
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="text-lg font-medium text-gray-600">Belum ada data anggota.</p>
                                <p class="text-sm text-gray-400 mt-1">Silakan tambahkan anggota baru atau ganti filter pencarian.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CSS Tambahan untuk Animasi --}}
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-element {
        opacity: 0; animation: fadeInUp 0.5s ease-out forwards;
    }
</style>
@endsection