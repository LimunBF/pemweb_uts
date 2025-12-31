<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Menentukan nama tabel agar tidak dianggap 'peminjamen' oleh Laravel
    protected $table = 'peminjamans';

    // Daftar kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'user_id',
        'item_id',
        'kode_peminjaman',
        'amount',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'alasan',
        'approver_id',
        'file_surat', // <-- Pastikan ada koma di sini
    ];

    // Relasi: Peminjaman milik satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Peminjaman meminjam satu Item
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}