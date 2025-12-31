@extends('layouts.app')

@section('content')
<div class="container mx-auto font-poppins">
    
   {{-- Header Banner --}}
   <div class="bg-gradient-to-r from-lab-text to-lab-pink-btn rounded-2xl p-6 md:p-8 mb-6 text-white shadow-lg relative overflow-hidden animate-element">
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12 translate-x-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="w-full md:flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold">Daftar Anggota Laboratorium</h1>
                <p class="mt-1 text-pink-100 opacity-90">Kelola semua data mahasiswa dan dosen disini.</p>
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

        <div class="overflow-x-auto relative min-h-[300px]">
            {{-- TABEL UTAMA --}}
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <img class="h-8 w-8 rounded-full bg-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" alt="">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $member->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $member->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{-- Logika Role --}}
                                @if($member->identity_number)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-gray-100 text-gray-800 border border-gray-200">{{ $member->identity_number }}</span>
                                @else
                                    <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">Mahasiswa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($member->role) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $member->email }}</div>
                                <div class="text-xs text-gray-400">{{ $member->contact ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('members.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">Edit</a>
                                <button type="button" onclick="confirmDelete('{{ $member->id }}')" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">Hapus</button>
                                <form id="delete-form-{{ $member->id }}" action="{{ route('members.destroy', $member->id) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-500 animate-fade-in-up">
                                
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-48 h-48 mb-6 relative">
                                        <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-pink-100">
                                            <circle cx="100" cy="100" r="80" fill="currentColor" opacity="0.3"/>
                                            <path d="M65 85H135C140.523 85 145 89.4772 145 95V145C145 150.523 140.523 155 135 155H65C59.4772 155 55 150.523 55 145V95C55 89.4772 59.4772 85 65 85Z" fill="white" stroke="#DB2777" stroke-width="4"/>
                                            <path d="M55 95L100 120L145 95" stroke="#DB2777" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M85 70L65 85H135L115 70H85Z" fill="white" stroke="#DB2777" stroke-width="4" stroke-linejoin="round"/>
                                            {{-- Magnifying Glass --}}
                                            <g transform="translate(110, 110)">
                                                <circle cx="35" cy="35" r="25" fill="white" stroke="#590D22" stroke-width="4"/>
                                                <path d="M55 55L75 75" stroke="#590D22" stroke-width="6" stroke-linecap="round"/>
                                                <path d="M25 25L45 45" stroke="#DB2777" stroke-width="3" stroke-linecap="round"/>
                                                <path d="M45 25L25 45" stroke="#DB2777" stroke-width="3" stroke-linecap="round"/>
                                            </g>
                                        </svg>
                                    </div>

                                    <h3 class="text-xl font-bold text-gray-800">Data Tidak Ditemukan</h3>
                                    <p class="text-gray-500 mt-2 max-w-sm mx-auto">
                                        Kami tidak dapat menemukan anggota dengan kata kunci tersebut. Coba ubah pencarian Anda.
                                    </p>

                                    <button onclick="document.getElementById('searchInput').value=''; fetchData();" class="mt-6 px-6 py-2 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200 transition font-bold text-sm">
                                        Bersihkan Pencarian
                                    </button>
                                </div>

                            </td>
                        </tr>
                    @endforelse
                </tbody>

                <tbody id="table-skeleton" class="bg-white divide-y divide-gray-200 hidden">
                    @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td class="px-6 py-4"><div class="h-4 w-4 skeleton"></div></td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full skeleton mr-4"></div>
                                <div class="space-y-1">
                                    <div class="h-4 w-24 skeleton"></div>
                                    <div class="h-3 w-16 skeleton"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4"><div class="h-5 w-20 skeleton rounded"></div></td>
                        <td class="px-6 py-4"><div class="h-4 w-16 skeleton"></div></td>
                        <td class="px-6 py-4 space-y-1">
                            <div class="h-4 w-32 skeleton"></div>
                            <div class="h-3 w-20 skeleton"></div>
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <div class="h-8 w-12 skeleton rounded-lg"></div>
                            <div class="h-8 w-14 skeleton rounded-lg"></div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

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
        const tableBody = document.getElementById('table-body');
        const tableSkeleton = document.getElementById('table-skeleton');
        const spinner = document.getElementById('search-spinner');

        tableBody.classList.add('hidden');
        tableSkeleton.classList.remove('hidden');
        spinner.classList.remove('hidden'); 
        
        const params = new URLSearchParams();
        if(currentRole) params.append('role', currentRole);
        if(search) params.append('search', search);
        
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.pushState({}, '', newUrl);

        try {
            const response = await fetch(newUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if(response.ok) {
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newRows = doc.getElementById('table-body').innerHTML;

                setTimeout(() => {
                    tableBody.innerHTML = newRows;
                    
                    tableSkeleton.classList.add('hidden');
                    tableBody.classList.remove('hidden');
                    spinner.classList.add('hidden');
                    
                    document.querySelectorAll('.animate-element').forEach(el => {
                        el.style.animation = 'none';
                        el.offsetHeight; 
                        el.style.animation = null; 
                    });
                }, 300); 
            }
        } catch (error) {
            console.error('Error:', error);
            // Jika error, kembalikan tampilan
            tableSkeleton.classList.add('hidden');
            tableBody.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    }
</script>
@endsection