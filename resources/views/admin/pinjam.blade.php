@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-3xl font-bold text-lab-text">Daftar Peminjaman</h2>
    {{-- Jika ingin menambah peminjaman manual via admin --}}
    </div>

<div class="bg-white shadow-xl rounded-lg overflow-hidden border border-gray-100">
    <table class="min-w-full divide-y divide-pink-200">
        <thead class="bg-lab-pink">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Peminjam</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Barang</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Tgl Pinjam</th>
                <th class="px-6 py-3 text-left text-xs font-bold text-lab-text uppercase">Tgl Kembali (Rencana)</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-lab-text uppercase">Status</th>
                <th class="px-6 py-3 text-center text-xs font-bold text-lab-text uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($peminjaman as $item)
            <tr class="hover:bg-pink-50 transition">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-bold text-gray-900">{{ $item->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $item->user->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    {{-- Pastikan relasi di model Peminjaman bernama 'item' --}}
                    <div class="text-sm text-gray-900 font-medium">{{ $item->item->nama_alat ?? 'Item Dihapus' }}</div>
                    <div class="text-xs text-gray-500">{{ $item->item->kode_alat ?? '-' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($item->status == 'disetujui' || $item->status == 'dipinjam')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Sedang Dipinjam</span>
                    @elseif($item->status == 'pending')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                    @elseif($item->status == 'dikembalikan')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                    @elseif($item->status == 'terlambat')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Terlambat</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    {{-- Tambahkan tombol aksi (Setujui/Kembalikan) di sini nanti --}}
                    <button class="text-blue-600 hover:text-blue-900">Detail</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $peminjaman->links() }}
</div>
@endsection