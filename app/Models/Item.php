<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'deskripsi',
        'jumlah_total',
        'status_ketersediaan',
        'status_tugas'
    ];

    // Relasi: Satu Item bisa punya banyak Peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // 1. Hitung berapa yang sedang dipinjam (Status: disetujui ATAU pending)
    public function getStokDipinjamAttribute()
    {
        // Kita anggap barang 'tidak ready' jika sedang dipinjam ATAU sedang diajukan (pending)
        // Supaya tidak rebutan stok.
        return $this->peminjamans()
                    ->whereIn('status', ['disetujui', 'pending'])
                    ->whereDate('tanggal_kembali', '>=', now()) // Hanya yang belum kembali
                    ->sum('amount'); // <--- Ganti count() jadi sum('amount')
    }

    // 2. Hitung Sisa Ready (Total - Dipinjam)
    public function getStokReadyAttribute()
    {
        $sisa = $this->jumlah_total - $this->stok_dipinjam;
        
        // Pastikan tidak minus (jaga-jaga)
        return max(0, $sisa);
    }
}