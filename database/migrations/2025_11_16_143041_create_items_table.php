<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alat')->unique()->nullable(); // Untuk UAS [cite: 23]
            $table->string('nama_alat'); // Untuk UTS/UAS [cite: 23]
            $table->text('deskripsi')->nullable(); // Untuk UAS [cite: 23]
            $table->integer('jumlah_total')->default(1); // Untuk UAS [cite: 24]
            $table->string('status_ketersediaan')->default('Tersedia'); // Untuk UAS (mis: Tersedia, Dipinjam, Perbaikan) [cite: 24]
            
            // Kolom khusus untuk soal UTS 
            $table->string('status_tugas')->default('belum selesai'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
