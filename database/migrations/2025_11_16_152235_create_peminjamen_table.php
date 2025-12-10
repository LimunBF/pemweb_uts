<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User (Peminjam)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // FIX 1: Ubah 'items' menjadi 'item_id' agar sesuai dengan kode di Seeder & Model
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            
            // Status Peminjaman
            $table->string('status')->default('dipinjam'); 
            
            // FIX 2: Tambahkan kolom 'approver_id' untuk menyimpan siapa admin yang menyetujui
            // Kita buat nullable() karena saat baru diajukan (pending), belum ada yang approve.
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};