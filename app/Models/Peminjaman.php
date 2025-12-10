<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'item_id', // Pastikan pakai item_id, bukan task_id
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'approver_id' // Opsional jika ada
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