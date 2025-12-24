<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // --- TAMBAHKAN BARIS INI ---
    // Memberitahu Laravel bahwa nama tabelnya adalah 'peminjamans', bukan 'peminjamen'
    protected $table = 'peminjamans'; 

    protected $fillable = [
        'user_id',
        'item_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'approver_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}