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
            
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->string('kode_peminjaman')->nullable()->index(); 

            // KOLOM BARU: JUMLAH BARANG
            $table->integer('amount')->default(1);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            // Default 'pending' agar sesuai logika controller (menunggu admin)
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dikembalikan', 'terlambat'])->default('pending');
            
            // 6. Alasan / Keperluan (Kolom Baru)
            $table->text('alasan')->nullable(); 
            // 7. Relasi ke Admin (Approver)
            $table->foreignId('approver_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};