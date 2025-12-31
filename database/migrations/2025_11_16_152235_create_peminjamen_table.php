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
            
            // Relasi ke User & Item
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            
            // Kode unik untuk pengelompokan
            $table->string('kode_peminjaman')->nullable()->index(); 

            // Jumlah Barang
            $table->integer('amount')->default(1);
            
            // Tanggal
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            
            // Status Peminjaman
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dikembalikan', 'terlambat'])->default('pending');
            
            // Alasan Peminjaman
            $table->text('alasan')->nullable(); 
            
            // --- KOLOM PENTING YANG SEBELUMNYA KURANG ---
            // Menyimpan nama file surat yang diupload mahasiswa
            $table->string('file_surat')->nullable();

            // Relasi ke Admin yang menyetujui (Approver)
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};