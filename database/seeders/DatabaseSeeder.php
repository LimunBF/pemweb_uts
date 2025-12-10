<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Peminjaman; // Pastikan ini di-import!
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------
        // 1. SEEDER USER (Akun Login)
        // ---------------------------------------------------
        
        $admin = User::create([
            'name' => 'Administrator Lab',
            'email' => 'admin@lab.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'identity_number' => 'ADM001',
            'contact' => '081234567890',
        ]);

        $student = User::create([
            'name' => 'Budi Santoso',
            'email' => 'mahasiswa@lab.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'identity_number' => 'MHS12345',
            'contact' => '089876543210',
        ]);

        // ---------------------------------------------------
        // 2. SEEDER BARANG (Inventaris Lab)
        // ---------------------------------------------------

        $items_data = [
            [
                'nama_alat' => 'Mikroskop Binokuler Olympus',
                'kode_alat' => 'LAB-BIO-001',
                'deskripsi' => 'Mikroskop optik dengan pembesaran hingga 1000x, cocok untuk pengamatan sel biologi.',
                'jumlah_total' => 10,
                'status_ketersediaan' => 'Tersedia',
            ],
            [
                'nama_alat' => 'Arduino Uno R3 Kit',
                'kode_alat' => 'LAB-ELKA-005',
                'deskripsi' => 'Microcontroller board berbasis ATmega328P lengkap dengan kabel USB.',
                'jumlah_total' => 25,
                'status_ketersediaan' => 'Tersedia',
            ],
            [
                'nama_alat' => 'Multimeter Digital Fluke',
                'kode_alat' => 'LAB-ELKA-012',
                'deskripsi' => 'Alat ukur tegangan, arus, dan hambatan listrik dengan presisi tinggi.',
                'jumlah_total' => 5,
                'status_ketersediaan' => 'Tersedia', 
            ],
            [
                'nama_alat' => 'Laptop ASUS ROG Strix',
                'kode_alat' => 'LAB-KOM-003',
                'deskripsi' => 'Laptop spesifikasi tinggi untuk rendering dan pemrograman berat. Core i7, RTX 3060.',
                'jumlah_total' => 3,
                'status_ketersediaan' => 'Tersedia',
            ],
            [
                'nama_alat' => 'Proyektor Epson EB-X400',
                'kode_alat' => 'LAB-UMUM-001',
                'deskripsi' => 'Proyektor LCD XGA 3300 Lumens, cocok untuk presentasi ruang kelas.',
                'jumlah_total' => 2,
                'status_ketersediaan' => 'Tersedia',
            ],
            // ... item lainnya (opsional)
        ];

        // Simpan items ke variabel agar mudah diambil ID-nya
        foreach ($items_data as $data) {
            Item::create($data);
        }

        // Ambil data item yang baru saja dibuat untuk keperluan relasi peminjaman
        $arduino = Item::where('nama_alat', 'Arduino Uno R3 Kit')->first();
        $mikroskop = Item::where('nama_alat', 'Mikroskop Binokuler Olympus')->first();
        $multimeter = Item::where('nama_alat', 'Multimeter Digital Fluke')->first();
        $laptop = Item::where('nama_alat', 'Laptop ASUS ROG Strix')->first();

        // ---------------------------------------------------
        // 3. SEEDER PEMINJAMAN (Riwayat & Aktif)
        // ---------------------------------------------------

        // KASUS A: Sedang Dipinjam (Status: disetujui)
        // Peminjaman normal, belum deadline
        Peminjaman::create([
            'user_id' => $student->id,
            'item_id' => $arduino->id,
            'tanggal_pinjam' => Carbon::now()->subDays(2), // Pinjam 2 hari lalu
            'tanggal_kembali' => Carbon::now()->addDays(5), // Deadline 5 hari lagi
            'status' => 'disetujui',
            'approver_id' => $admin->id,
        ]);

        // KASUS B: Menunggu Konfirmasi (Status: pending)
        // Baru diajukan hari ini
        Peminjaman::create([
            'user_id' => $student->id,
            'item_id' => $mikroskop->id,
            'tanggal_pinjam' => Carbon::now()->addDay(), // Rencana pinjam besok
            'tanggal_kembali' => Carbon::now()->addDays(2), 
            'status' => 'pending',
            'approver_id' => null, // Belum disetujui admin
        ]);

        // KASUS C: Terlambat (Status: terlambat)
        // Seharusnya kembali kemarin
        Peminjaman::create([
            'user_id' => $student->id,
            'item_id' => $multimeter->id,
            'tanggal_pinjam' => Carbon::now()->subDays(10), // Pinjam 10 hari lalu
            'tanggal_kembali' => Carbon::now()->subDay(),   // Deadline KEMARIN (Terlambat)
            'status' => 'terlambat', 
            'approver_id' => $admin->id,
        ]);
        
        // KASUS D: Sudah Dikembalikan (Status: dikembalikan) - Opsional, untuk riwayat
        // Peminjaman bulan lalu
        Peminjaman::create([
            'user_id' => $student->id,
            'item_id' => $laptop->id,
            'tanggal_pinjam' => Carbon::now()->subMonth(),
            'tanggal_kembali' => Carbon::now()->subMonth()->addDays(3),
            'status' => 'dikembalikan',
            'approver_id' => $admin->id,
        ]);

    }
}