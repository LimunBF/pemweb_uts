<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. BUAT AKUN PENGGUNA (USERS)
        // ==========================================
        
        // 1. ADMIN (admin@lab.com)
        $admin = User::create([
            'name' => 'Administrator Lab',
            'email' => 'admin@lab.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'identity_number' => 'ADM001',
            'contact' => '081234567890'
        ]);

        // 2. DOSEN (budi@dosen.com)
        $dosen = User::create([
            'name' => 'Budi Santoso, M.Kom',
            'email' => 'budi@dosen.com',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
            'identity_number' => 'NIP19850101',
            'contact' => '081122334455'
        ]);

        // 3. MAHASISWA (siti@mhs.com)
        $mahasiswa = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@mhs.com',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
            'identity_number' => 'M0519001',
            'contact' => '089876543210'
        ]);

        // ==========================================
        // 2. BUAT DATA BARANG (ITEMS)
        // ==========================================
        
        $laptop = Item::create([
            'kode_alat' => 'LPT-001',
            'nama_alat' => 'Laptop ASUS ROG',
            'deskripsi' => 'Laptop spesifikasi tinggi untuk praktikum multimedia dan rendering.',
            'jumlah_total' => 10,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Selesai'
        ]);

        $proyektor = Item::create([
            'kode_alat' => 'PRJ-002',
            'nama_alat' => 'Proyektor Epson',
            'deskripsi' => 'Proyektor HDMI untuk presentasi di ruang sidang.',
            'jumlah_total' => 5,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Selesai'
        ]);

        $kamera = Item::create([
            'kode_alat' => 'CAM-003',
            'nama_alat' => 'Kamera DSLR Canon',
            'deskripsi' => 'Kamera untuk dokumentasi kegiatan himpunan.',
            'jumlah_total' => 3,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Selesai'
        ]);

        // ==========================================
        // 3. BUAT DATA PEMINJAMAN CONTOH
        // ==========================================
        
        // Contoh: Mahasiswa meminjam Laptop (Pending)
        Peminjaman::create([
            'user_id' => $mahasiswa->id,
            'item_id' => $laptop->id,
            'kode_peminjaman' => 'LOAN-' . $mahasiswa->id . '-' . time(),
            'amount' => 1,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali' => Carbon::today()->addDays(3),
            'status' => 'pending',
            'alasan' => 'Untuk pengerjaan Skripsi',
            'file_surat' => null 
        ]);

        // Contoh: Mahasiswa meminjam Kamera (Disetujui Admin)
        Peminjaman::create([
            'user_id' => $mahasiswa->id,
            'item_id' => $kamera->id,
            'kode_peminjaman' => 'LOAN-' . $mahasiswa->id . '-' . (time() - 1000),
            'amount' => 1,
            'tanggal_pinjam' => Carbon::yesterday(),
            'tanggal_kembali' => Carbon::tomorrow(),
            'status' => 'disetujui', 
            'alasan' => 'Dokumentasi acara seminar',
            'approver_id' => $admin->id
        ]);
    }
}