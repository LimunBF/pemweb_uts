<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'deskripsi',
        'jumlah_total',
        'status_ketersediaan',
        'status_tugas',
    ];

    /**
     * Relasi ke Peminjaman
     * Satu barang bisa dipinjam berkali-kali
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'item_id');
    }

    /**
     * ACCESSOR: Menghitung Stok yang Sedang Dipinjam
     * Cara panggil: $item->stok_dipinjam
     */
    public function getStokDipinjamAttribute()
    {
        // Hitung jumlah barang ini yang ada di tabel peminjaman
        // dengan status 'pending' atau 'disetujui' (belum kembali)
        return $this->peminjamans()
                    ->whereIn('status', ['pending', 'disetujui'])
                    ->sum('amount');
    }

    /**
     * ACCESSOR: Menghitung Sisa Stok Ready
     * Cara panggil: $item->stok_ready
     */
    public function getStokReadyAttribute()
    {
        // Stok Ready = Total Punya Lab - Yang Sedang Dipinjam
        $ready = $this->jumlah_total - $this->stok_dipinjam;
        
        // Pastikan tidak minus (jika ada kesalahan data)
        return max($ready, 0);
    }
}