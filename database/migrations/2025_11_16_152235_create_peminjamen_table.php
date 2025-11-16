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
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            
            // Siapa yang pinjam
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Apa yang dipinjam
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            
            // Kapan [cite: 27, 29]
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            
            // Status approval oleh Admin [cite: 31]
            $table->string('status')->default('pending'); // (pending, disetujui, ditolak, dikembalikan)
            $table->foreignId('approver_id')->nullable()->constrained('users'); // ID Admin yg approve
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
