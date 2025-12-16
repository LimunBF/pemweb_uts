@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- HEADER PAGE --}}
    <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-gray-800 to-lab-pink-btn">
                Riwayat Peminjaman
            </h1>
            <p class="text-gray-500 text-sm mt-1 flex items-center gap-1">
                <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Pantau status dan unduh surat izin peminjaman.
            </p>
        </div>
        <a href="{{ route('student.loan.form') }}" class="bg-gradient-to-r from-lab-text to-lab-pink-btn hover:from-pink-700 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-pink-200 transition transform hover:-translate-y-0.5 flex items-center gap-2 group">
            <div class="bg-white/20 p-1 rounded-full group-hover:rotate-90 transition duration-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <span>Pinjam Baru</span>
        </a>
    </div>

    {{-- TABLE CONTAINER --}}
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden relative">
        {{-- Hiasan Garis Atas --}}
        <div class="h-1 bg-gradient-to-r from-lab-text to-lab-pink-btn w-full"></div>

        @if($groupedLoans->isEmpty())
            <div class="p-16 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-pink-50 rounded-full flex items-center justify-center mb-4 text-pink-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-700">Belum ada riwayat</h3>
                <p class="text-gray-400 text-sm">Anda belum pernah melakukan peminjaman alat.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    {{-- TABLE HEADER --}}
                    <thead class="bg-pink-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                Barang & Keperluan
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-pink-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                    Jml
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-pink-600 uppercase tracking-wider">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Tanggal
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-pink-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Status
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-pink-600 uppercase tracking-wider">
                                <div class="flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Aksi
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($groupedLoans as $groupKey => $loans)
                            @php
                                $firstLoan = $loans->first();
                                $count = $loans->count();
                                $isMulti = $count > 1;
                                
                                $statusBadge = match($firstLoan->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                                    'disetujui' => 'bg-green-100 text-green-700 border border-green-200',
                                    'ditolak' => 'bg-red-100 text-red-700 border border-red-200',
                                    'dikembalikan' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                    'terlambat' => 'bg-gray-800 text-white border border-gray-600',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp

                            {{-- MAIN ROW --}}
                            <tr class="hover:bg-pink-50/40 transition cursor-pointer {{ $isMulti ? 'group-trigger' : '' }} group">
                                
                                {{-- Kolom 1: Barang & Alasan --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        {{-- Ikon Dropdown (Lingkaran Pink) --}}
                                        @if($isMulti)
                                            <div class="mr-3 mt-1 w-6 h-6 rounded-full bg-pink-100 text-lab-pink-btn flex items-center justify-center transform transition-transform duration-300 arrow-icon shadow-sm group-hover:bg-lab-pink-btn group-hover:text-white">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        @else
                                            {{-- Ikon Barang Single --}}
                                            <div class="mr-3 mt-1 w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="text-sm font-bold text-gray-800 flex items-center gap-2 group-hover:text-lab-pink-btn transition">
                                                {{ $firstLoan->item->nama_alat }}
                                                @if($isMulti)
                                                    <span class="text-[10px] bg-pink-100 text-lab-pink-btn px-2 py-0.5 rounded-full font-bold shadow-sm">
                                                        +{{ $count - 1 }} Lainnya
                                                    </span>
                                                @endif
                                            </div>
                                            {{-- Alasan dengan Style Kutipan --}}
                                            <div class="text-xs text-gray-500 mt-1.5 flex items-start gap-1">
                                                <svg class="w-3 h-3 text-gray-300 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V5H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM5.0166 21L5.0166 18C5.0166 16.8954 5.91203 16 7.0166 16H10.0166C10.5689 16 11.0166 15.5523 11.0166 15V9C11.0166 8.44772 10.5689 8 10.0166 8H6.0166C5.46432 8 5.0166 8.44772 5.0166 9V11C5.0166 11.5523 4.56889 12 4.0166 12H3.0166V5H13.0166V15C13.0166 18.3137 10.3303 21 7.0166 21H5.0166Z"></path></svg>
                                                <span class="italic">"{{ Str::limit($firstLoan->alasan ?? 'Tidak ada keterangan', 60) }}"</span>
                                            </div>
                                            <div class="text-[10px] text-gray-400 mt-1 font-mono">
                                                #{{ $firstLoan->kode_peminjaman ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom 2: Jumlah --}}
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center px-3 py-1 bg-gray-50 rounded-lg text-sm font-bold text-gray-700 shadow-sm border border-gray-100 group-hover:border-pink-200 group-hover:bg-white transition">
                                        @if($isMulti)
                                            {{ $loans->sum('amount') }} Unit
                                        @else
                                            {{ $firstLoan->amount }} Unit
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom 3: Tanggal (Combined) --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col text-xs">
                                        <span class="font-bold text-gray-700 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($firstLoan->tanggal_pinjam)->format('d M Y') }}
                                        </span>
                                        <span class="text-gray-400 text-[10px] ml-4">s/d</span>
                                        <span class="font-bold text-gray-700 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($firstLoan->tanggal_kembali)->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Kolom 5: Status --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm {{ $statusBadge }}">
                                        {{ ucfirst($firstLoan->status) }}
                                    </span>
                                </td>

                                {{-- Kolom 6: Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if(in_array($firstLoan->status, ['pending', 'disetujui']))
                                        <a href="{{ route('student.loan.print', $firstLoan->id) }}" 
                                           onclick="event.stopPropagation()"
                                           target="_blank"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-pink-200 text-lab-pink-btn text-xs font-bold rounded-lg shadow-sm hover:bg-lab-pink-btn hover:text-white hover:border-transparent transition-all duration-200 group/btn">
                                            <svg class="w-4 h-4 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Surat Izin
                                        </a>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                            </tr>

                            {{-- DETAIL ROW (Accordion) --}}
                            @if($isMulti)
                                <tr class="hidden detail-row">
                                    <td colspan="6" class="p-0 border-none">
                                        <div class="bg-pink-50/30 border-y border-pink-100 shadow-inner px-8 py-4">
                                            <p class="text-[10px] font-bold text-pink-400 uppercase tracking-wider mb-3 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                                Rincian Item dalam Pengajuan Ini:
                                            </p>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                                @foreach($loans as $detail)
                                                    <div class="bg-white p-3 rounded-xl border border-pink-100 flex justify-between items-center shadow-sm">
                                                        <div class="flex items-center gap-2">
                                                            <div class="w-2 h-2 rounded-full bg-lab-pink-btn"></div>
                                                            <span class="text-sm font-medium text-gray-700">{{ $detail->item->nama_alat }}</span>
                                                        </div>
                                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ $detail->amount }} Unit</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const triggers = document.querySelectorAll('.group-trigger');

        triggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const detailRow = this.nextElementSibling;
                const arrow = this.querySelector('.arrow-icon');
                const badge = this.querySelector('.group-hover\\:bg-lab-pink-btn'); // Target lingkaran panah

                if (detailRow && detailRow.classList.contains('detail-row')) {
                    detailRow.classList.toggle('hidden');
                    
                    if (detailRow.classList.contains('hidden')) {
                        arrow.style.transform = 'rotate(0deg)';
                        this.classList.remove('bg-pink-50/60'); // Remove active bg
                    } else {
                        arrow.style.transform = 'rotate(180deg)';
                        this.classList.add('bg-pink-50/60'); // Active state bg
                    }
                }
            });
        });
    });
</script>
@endsection