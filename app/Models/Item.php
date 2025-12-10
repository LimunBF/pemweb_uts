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

    // Accessor: Hitung barang yang sedang dipinjam (Status: 'disetujui')
    public function getStokDipinjamAttribute()
    {
        // Asumsi: 1 record peminjaman = 1 unit barang
        // Kita hitung jumlah peminjaman yang statusnya 'disetujui' (belum dikembalikan)
        return $this->peminjamans()->where('status', 'disetujui')->count();
    }

    // Accessor: Hitung sisa stok yang ready
    public function getStokReadyAttribute()
    {
        return $this->jumlah_total - $this->stok_dipinjam;
    }
}