@extends('layouts.app')

@section('content')
    {{-- UPDATE: Hapus px-6 py-8 agar sama persis dengan Inventory --}}
    <div class="container mx-auto">

        {{-- LOGIC PHP: Cek Keterlambatan --}}
        @php
            $hasLateItems = $groupedLoans->flatten()->contains('status', 'terlambat');
        @endphp

        {{-- 1. WARNING ALERT (Tetap ada margin-bottom mb-6 agar rapi) --}}
        @if($hasLateItems)
            <div class="mb-6 bg-red-600 rounded-xl shadow-lg shadow-red-200 p-5 flex flex-col md:flex-row items-center justify-between gap-4 text-white animate-pulse border border-red-700">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-full">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">PERINGATAN: Pengembalian Terlambat!</h3>
                        <p class="text-red-100 text-sm">Ada barang yang belum dikembalikan melewati batas waktu. Mohon segera diproses.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- 2. HEADER PAGE (Struktur mb-6 sama dengan Inventory) --}}
        <div class="mb-6 flex flex-col md:flex-row justify-between items-end md:items-center gap-4">
            <div>
                {{-- Font size disamakan: text-2xl font-bold text-lab-text --}}
                <h2 class="text-2xl font-bold text-lab-text">Riwayat Peminjaman</h2>
                <p class="text-sm text-gray-500 mt-1">Pantau status pengajuan dan unduh surat izin.</p>
            </div>
            
            <a href="{{ route('student.loan.form') }}" class="bg-gradient-to-r from-lab-text to-lab-pink-btn hover:from-pink-700 hover:to-pink-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg hover:shadow-pink-200 transition transform hover:-translate-y-0.5 flex items-center gap-2 group">
                <div class="bg-white/20 p-1 rounded-full group-hover:rotate-90 transition duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span>Pinjam Baru</span>
            </a>
        </div>

        {{-- 3. TABLE CONTAINER (Sama persis Inventory: bg-white rounded-xl shadow-lg border-pink-100) --}}
        <div class="bg-white rounded-xl shadow-lg border border-pink-100 overflow-hidden">
            
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
                    {{-- Table Class sama persis Inventory --}}
                    <table class="min-w-full divide-y divide-pink-200">
                        <thead class="bg-lab-pink">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-lab-text uppercase tracking-wider">Barang & Keperluan</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-lab-text uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-lab-text uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-lab-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-lab-text uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
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
                                        'terlambat' => 'bg-red-600 text-white border border-red-700 shadow-md animate-pulse',
                                        default => 'bg-gray-100 text-gray-600'
                                    };

                                    // Hitung Hari & Jam
                                    $lateText = '';
                                    if ($firstLoan->status == 'terlambat') {
                                        $deadline = \Carbon\Carbon::parse($firstLoan->tanggal_kembali);
                                        $now = \Carbon\Carbon::now();
                                        $diff = $deadline->diff($now);
                                        
                                        $parts = [];
                                        if ($diff->d > 0) $parts[] = $diff->d . ' Hari';
                                        if ($diff->h > 0) $parts[] = $diff->h . ' Jam';
                                        
                                        $timeString = implode(' ', $parts);
                                        $lateText = 'Terlambat ' . ($timeString ?: 'Baru saja'); 
                                    }

                                    if ($firstLoan->file_surat) {
                                        $downloadUrl = asset('storage/' . $firstLoan->file_surat);
                                        $btnLabel = 'Unduh (Upload)';
                                    } else {
                                        $downloadUrl = route('student.loan.print', $firstLoan->id);
                                        $btnLabel = 'Unduh (Docx)';
                                    }
                                @endphp

                                {{-- ROW UTAMA --}}
                                {{-- Hover effect disamakan: hover:bg-pink-50 --}}
                                <tr class="transition cursor-pointer {{ $isMulti ? 'group-trigger' : '' }} group {{ $firstLoan->status == 'terlambat' ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-pink-50' }}">
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            @if($isMulti)
                                                <div class="mr-3 mt-1 w-6 h-6 rounded-full {{ $firstLoan->status == 'terlambat' ? 'bg-red-200 text-red-600' : 'bg-pink-100 text-lab-pink-btn' }} flex items-center justify-center transform transition-transform duration-300 arrow-icon shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7"></path></svg>
                                                </div>
                                            @else
                                                <div class="mr-3 mt-1 w-6 h-6 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                </div>
                                            @endif

                                            <div>
                                                {{-- Text color group hover disamakan --}}
                                                <div class="text-sm font-bold text-gray-900 group-hover:text-lab-pink-btn transition-colors">
                                                    {{ $firstLoan->item->nama_alat }}
                                                    @if($isMulti)
                                                        <span class="text-[10px] {{ $firstLoan->status == 'terlambat' ? 'bg-red-200 text-red-800' : 'bg-pink-100 text-lab-pink-btn' }} px-2 py-0.5 rounded-full font-bold shadow-sm">+{{ $count - 1 }} Lainnya</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <span class="italic">"{{ Str::limit($firstLoan->alasan ?? 'Tidak ada keterangan', 50) }}"</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="inline-flex items-center justify-center px-3 py-1 bg-white rounded-lg text-sm font-bold text-gray-700 shadow-sm border border-gray-200">
                                            {{ $isMulti ? $loans->sum('amount') : $firstLoan->amount }} Unit
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col text-xs">
                                            <span class="font-bold text-gray-700 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                {{ \Carbon\Carbon::parse($firstLoan->tanggal_pinjam)->format('d M Y') }}
                                            </span>
                                            <span class="text-gray-400 text-[10px] ml-4 my-0.5">s/d</span>
                                            <span class="font-bold {{ $firstLoan->status == 'terlambat' ? 'text-red-600' : 'text-gray-700' }} flex items-center gap-1">
                                                <svg class="w-3 h-3 {{ $firstLoan->status == 'terlambat' ? 'text-red-600' : 'text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ \Carbon\Carbon::parse($firstLoan->tanggal_kembali)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center gap-1.5">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm {{ $statusBadge }}">
                                                {{ ucfirst($firstLoan->status) }}
                                            </span>
                                            @if($firstLoan->status == 'terlambat')
                                                <span class="text-[10px] font-extrabold text-red-600 bg-red-100 px-3 py-1 rounded-md border border-red-200">
                                                    {{ $lateText }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if(in_array($firstLoan->status, ['pending', 'disetujui']))
                                            <a href="{{ $downloadUrl }}" 
                                               onclick="event.stopPropagation()"
                                               target="_blank" 
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-pink-200 text-lab-pink-btn text-xs font-bold rounded-lg shadow-sm hover:bg-lab-pink-btn hover:text-white hover:border-transparent transition-all duration-200 group/btn">
                                                <svg class="w-4 h-4 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                {{ $btnLabel }}
                                            </a>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                </tr>

                                @if($isMulti)
                                    <tr class="hidden detail-row">
                                        <td colspan="6" class="p-0 border-none">
                                            <div class="bg-pink-50 border-y border-pink-200 shadow-inner px-8 py-4">
                                                <p class="text-[10px] font-bold text-lab-text uppercase tracking-wider mb-3">Rincian Item:</p>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
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
                trigger.addEventListener('click', function(e) {
                    if(e.target.closest('a')) return;

                    const detailRow = this.nextElementSibling;
                    const arrow = this.querySelector('.arrow-icon');
                    if (detailRow && detailRow.classList.contains('detail-row')) {
                        detailRow.classList.toggle('hidden');
                        if (detailRow.classList.contains('hidden')) {
                            arrow.style.transform = 'rotate(0deg)';
                        } else {
                            arrow.style.transform = 'rotate(180deg)';
                        }
                    }
                });
            });
        });
    </script>
@endsection