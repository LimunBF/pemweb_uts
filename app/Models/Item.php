<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Tambahkan properti ini agar Mass Assignment (Create/Update) diizinkan
    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'deskripsi',
        'jumlah_total',
        'status_ketersediaan',
        'status_tugas'
    ];
}