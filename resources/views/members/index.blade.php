@extends('layouts.app')

@section('content')
<div class="container mx-auto font-poppins">
    
   {{-- Header Banner --}}
   <div class="bg-gradient-to-r from-pink-900 to-pink-600 rounded-2xl p-6 md:p-8 mb-6 text-white shadow-lg relative overflow-hidden animate-element">
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="w-full md:flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold">Daftar Anggota Laboratorium</h1>
                <p class="mt-1 text-pink-100 opacity-90">Kelola data admin, mahasiswa, dan dosen disini.</p>
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

    {{-- Controls: Filter & Search --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6 px-1 animate-element" style="animation-delay: 0.1s;">
        
        <div class="flex flex-wrap items-center gap-2">
            <button onclick="filterRole('')" id="btn-all"
               class="filter-btn px-5 py-2 text-sm rounded-full shadow-sm border transition duration-300 transform hover:scale-105
               {{ !request('role') 
                    ? 'active bg-pink-600 text-white border-pink-600 font-bold shadow-pink-200' 
                    : 'bg-white text-gray-600 border-gray-300 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 font-medium' }}">
                Semua
            </button>

            <button onclick="filterRole('mahasiswa')" id="btn-mahasiswa"
               class="filter-btn px-5 py-2 text-sm rounded-full shadow-sm border transition duration-300 transform hover:scale-105
               {{ request('role') == 'mahasiswa' 
                    ? 'active bg-pink-600 text-white border-pink-600 font-bold shadow-pink-200' 
                    : 'bg-white text-gray-600 border-gray-300 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 font-medium' }}">
                Mahasiswa
            </button>

            <button onclick="filterRole('dosen')" id="btn-dosen"
               class="filter-btn px-5 py-2 text-sm rounded-full shadow-sm border transition duration-300 transform hover:scale-105
               {{ request('role') == 'dosen' 
                    ? 'active bg-pink-600 text-white border-pink-600 font-bold shadow-pink-200' 
                    : 'bg-white text-gray-600 border-gray-300 hover:bg-pink-50 hover:text-pink-600 hover:border-pink-200 font-medium' }}">
                Dosen
            </button>
        </div>

        {{-- Search Input --}}
        <div class="relative w-full md:w-[500px]">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-pink-400 group-focus-within:text-pink-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" id="searchInput" onkeyup="debounceSearch()" 
                   class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:placeholder-gray-300 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 sm:text-sm transition shadow-sm" 
                   placeholder="Cari nama, email, nip/nim..." 
                   value="{{ request('search') }}">
            
            <div id="search-spinner" class="absolute inset-y-0 right-0 pr-3 flex items-center hidden">
                <svg class="animate-spin h-4 w-4 text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
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

    {{-- Tabel Data Container --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden animate-element relative min-h-[300px]" style="animation-delay: 0.2s;">
        
        <div id="table-loading" class="absolute inset-0 bg-white bg-opacity-70 z-20 hidden flex justify-center items-center backdrop-blur-sm transition-all duration-300">
            <div class="flex flex-col items-center">
                <svg class="animate-spin h-10 w-10 text-pink-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-sm font-semibold text-pink-600">Memuat Data...</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="members-table">
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
                <tbody class="bg-white divide-y divide-gray-200 transition-opacity duration-300" id="table-body">
                    @forelse($members as $index => $member)
                    <tr class="hover:bg-pink-50 transition duration-150 ease-in-out group animate-element" style="animation-delay: {{ $index * 0.05 }}s;">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        
                        {{-- Nama & Tanggal Bergabung --}}
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

                        {{-- Role --}}
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

                        {{-- Identitas --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                            {{ $member->identity_number ?? '-' }}
                        </td>

                        {{-- Kontak & Email --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex flex-col space-y-1.5">
                                @if($member->contact)
                                    <div class="flex items-center text-gray-700 font-medium">
                                        <svg class="w-3.5 h-3.5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-8.68-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.151-.174.2-.298.3-.495.099-.198.05-.372-.025-.52-.075-.149-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        {{ $member->contact }}
                                    </div>
                                @else
                                    <span class="text-gray-300 text-xs">- No HP -</span>
                                @endif

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
                            <div class="flex flex-col items-center justify-center animate-element">
                                <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <p class="text-lg font-medium text-gray-600">Tidak ada data ditemukan.</p>
                                <p class="text-sm text-gray-400 mt-1">Coba kata kunci lain atau ubah filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CSS --}}
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-element { opacity: 0; animation: fadeInUp 0.5s ease-out forwards; }
    
    .fade-out { opacity: 0.4; pointer-events: none; }
    .fade-in { opacity: 1; pointer-events: auto; }
</style>

<script>
    let currentRole = "{{ request('role') }}";
    let searchTimeout;

    function filterRole(role) {
        currentRole = role;
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active', 'bg-pink-600', 'text-white', 'border-pink-600', 'font-bold', 'shadow-pink-200');
            btn.classList.add('bg-white', 'text-gray-600', 'border-gray-300', 'font-medium', 'hover:bg-pink-50', 'hover:text-pink-600', 'hover:border-pink-200');
        });

        const activeBtnId = role ? 'btn-' + role : 'btn-all';
        const activeBtn = document.getElementById(activeBtnId);
        if(activeBtn) {
            activeBtn.classList.remove('bg-white', 'text-gray-600', 'border-gray-300', 'font-medium', 'hover:bg-pink-50', 'hover:text-pink-600', 'hover:border-pink-200');
            activeBtn.classList.add('active', 'bg-pink-600', 'text-white', 'border-pink-600', 'font-bold', 'shadow-pink-200');
        }

        fetchData();
    }

    function debounceSearch() {
        const spinner = document.getElementById('search-spinner');
        spinner.classList.remove('hidden');
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchData();
        }, 100); 
    }


    async function fetchData() {
        const search = document.getElementById('searchInput').value;
        const loadingOverlay = document.getElementById('table-loading');
        const spinner = document.getElementById('search-spinner');
        const tableBody = document.getElementById('table-body');

        loadingOverlay.classList.remove('hidden');
        
        const params = new URLSearchParams();
        if(currentRole) params.append('role', currentRole);
        if(search) params.append('search', search);
        
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.pushState({}, '', newUrl);

        try {
            const response = await fetch(newUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if(response.ok) {
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newRows = doc.getElementById('table-body').innerHTML;

                tableBody.classList.add('opacity-0');
                
                setTimeout(() => {
                    tableBody.innerHTML = newRows;
                    tableBody.classList.remove('opacity-0');
                    loadingOverlay.classList.add('hidden');
                    spinner.classList.add('hidden');
                }, 200); 
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            loadingOverlay.classList.add('hidden');
            spinner.classList.add('hidden');
        }
    }
</script>
@endsection