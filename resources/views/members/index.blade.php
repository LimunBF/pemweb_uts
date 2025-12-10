@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 mt-6">
    
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
        
        <div class="bg-lab-pink-dark px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            <div class="text-white">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Daftar Anggota
                </h2>
                <p class="text-sm text-pink-100 mt-1 opacity-90">Kelola data mahasiswa aktif di sini.</p>
            </div>

            <a href="#" class="mt-4 md:mt-0 bg-white text-lab-pink-dark hover:bg-gray-50 font-semibold py-2 px-4 rounded-lg shadow-sm flex items-center transition duration-200">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Anggota
            </a>
        </div>

        @if(session('success'))
        <div class="px-6 pt-4">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm flex items-center justify-between" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 font-bold">&times;</button>
            </div>
        </div>
        @endif

        <div class="p-0 overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">No HP</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    {{-- PERHATIKAN: Variabel di sini adalah $members, bukan $items --}}
                    @forelse($members as $index => $member)
                    <tr class="hover:bg-pink-50 transition duration-150 group">
                        <td class="px-6 py-4 text-center font-medium text-gray-500">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-800">{{ $member->name }}</div>
                            <div class="text-xs text-gray-400 mt-0.5">Bergabung: {{ $member->created_at->format('d M Y') }}</div>
                        </td>

                        <td class="px-6 py-4">
                            @if($member->identity_number)
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-mono font-semibold border border-gray-200">
                                    {{ $member->identity_number }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm italic">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $member->contact ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $member->email }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="#" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00 2 2h11a2 2 0 00 2-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>

                                <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 bg-gray-50">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"></path></svg>
                                <p class="text-lg font-medium text-gray-500">Data anggota kosong.</p>
                                <p class="text-sm">Silakan tambahkan data mahasiswa baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-white border-t border-gray-100 text-right text-sm text-gray-500">
            Total Anggota: <strong>{{ $members->count() }}</strong> Mahasiswa
        </div>
    </div>
</div>
@endsection