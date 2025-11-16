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
        Schema::table('users', function (Blueprint $table) {
            // (nama, email, password sudah ada)
            $table->string('role')->default('mahasiswa'); // (admin, dosen, mahasiswa) [cite: 28, 31]
            $table->string('identity_number')->nullable()->unique(); // (NIM/NIP) 
            $table->string('contact')->nullable(); // (Kontak/WA) 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
