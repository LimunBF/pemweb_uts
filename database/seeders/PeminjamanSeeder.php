<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item; // Asumsi model barangmu bernama Task
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Peminjam (Jika belum ada)
        $user1 = User::firstOrCreate(
            ['email' => 'mahasiswa@lab.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'dosen@lab.com'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Buat Data Barang/Alat (Tasks)
        $item1 = Item::create([
            'name' => 'Laptop Asus ROG',
            'description' => 'Laptop Gaming Inventaris Lab',
            // 'status' => 'Tersedia' // Uncomment jika ada kolom status
        ]);

        $item2 = Item::create([
            'name' => 'Proyektor Epson',
            'description' => 'Proyektor HD',
            // 'status' => 'Tersedia'
        ]);

        $item3 = Item::create([
            'name' => 'Arduino Uno Kit',
            'description' => 'Kit lengkap untuk IoT',
            // 'status' => 'Tersedia'
        ]);

        // 3. Buat Data Peminjaman
        Peminjaman::create([
            'user_id' => $user1->id,
            'item_id' => $item1->id,
            'tanggal_pinjam' => now()->subDays(2), // Pinjam 2 hari lalu
            'status' => 'dipinjam',
        ]);

        Peminjaman::create([
            'user_id' => $user2->id,
            'item_id' => $item2->id,
            'tanggal_pinjam' => now()->subDays(5),
            'tanggal_kembali' => now()->subDays(1),
            'status' => 'dikembalikan',
        ]);

        Peminjaman::create([
            'user_id' => $user1->id,
            'item_id' => $item3->id,
            'tanggal_pinjam' => now()->subDays(10),
            'status' => 'terlambat',
        ]);
    }
}