<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'peminjamans';
=======
    // --- TAMBAHKAN BARIS INI ---
    // Memberitahu Laravel bahwa nama tabelnya adalah 'peminjamans', bukan 'peminjamen'
    protected $table = 'peminjamans'; 
>>>>>>> feature/feature_member

    protected $fillable = [
        'user_id',
        'item_id',
<<<<<<< HEAD
        'kode_peminjaman',
        'amount',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'alasan',
        'approver_id',
        'file_surat' // <--- Tambahkan ini
=======
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'approver_id'
>>>>>>> feature/feature_member
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // GANTI DARI TASK KE ITEM
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}