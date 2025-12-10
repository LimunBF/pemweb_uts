<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Perhatikan nama tabelnya 'peminjamans' (plural)
        // Meskipun nama file kamu 'peminjamen', tabel yang dibuat tetap 'peminjamans'
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel tasks (barang)
            $table->foreignId('items')->constrained('items')->onDelete('cascade');
            
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            
            // Status: dipinjam, dikembalikan, terlambat
            $table->string('status')->default('dipinjam'); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};