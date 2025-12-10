<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database (jamak)
    protected $table = 'peminjamans';

    // Daftar kolom yang boleh diisi secara massal (create/update)
    protected $fillable = [
        'user_id',
        'task_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    /**
     * Relasi ke Model User
     * (Setiap peminjaman dimiliki oleh 1 user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Model Task (Barang)
     * (Setiap peminjaman terkait dengan 1 barang)
     */
    public function task()
    {
        // Pastikan model barangmu bernama 'Task'. 
        // Jika modelnya bernama 'Barang' atau 'Item', ganti menjadi 'Barang::class' atau 'Item::class'
        return $this->belongsTo(Task::class, 'task_id');
    }
}