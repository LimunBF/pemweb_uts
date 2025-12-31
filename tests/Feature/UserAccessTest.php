<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * =====================================================================
     * 1. TEST AKSES ADMIN (Admin Harus Bisa Buka Semua Halamannya)
     * =====================================================================
     */
    public function test_admin_can_access_all_admin_pages()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Buat 1 barang dummy untuk keperluan test halaman edit
        $item = Item::create([
            'kode_alat' => 'TEST-001',
            'nama_alat' => 'Barang Test',
            'jumlah_total' => 5,
            'stok_dipinjam' => 0,
            'status_ketersediaan' => 'Tersedia'
        ]);

        // Daftar Rute Admin yang akan dicek
        $adminRoutes = [
            route('dashboard_admin'),       // Dashboard
            route('items.index'),           // List Barang (Resource)
            route('inventaris.index'),      // List Barang (Custom)
            route('barang.create'),         // Form Tambah Barang
            route('barang.cetak'),          // Cetak Laporan Barang
            route('barang.edit', $item->id),// Form Edit Barang
            route('members.index'),         // Daftar Anggota
            route('peminjaman'),            // Daftar Peminjaman
            route('peminjaman.cetak'),      // Cetak Laporan Peminjaman
            route('peminjaman.create'),     // Form Peminjaman Manual (Admin)
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->get($route);
            // Pastikan status 200 (OK)
            $response->assertStatus(200);
        }
    }

    /**
     * =====================================================================
     * 2. TEST AKSES MAHASISWA (Mahasiswa Harus Bisa Buka Halamannya Sendiri)
     * =====================================================================
     */
    public function test_student_can_access_all_student_pages()
    {
        /** @var \App\Models\User $student */
        $student = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($student);

        // Daftar Rute Mahasiswa yang akan dicek
        $studentRoutes = [
            route('student.dashboard'),     // Dashboard Mhs
            route('student.inventory'),     // Katalog Barang
            route('student.loans'),         // Pinjaman Saya
            route('student.loan.form'),     // Form Pinjam
        ];

        foreach ($studentRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
        }
    }

    /**
     * =====================================================================
     * 3. TEST KEAMANAN: MAHASISWA MENCOBA JADI ADMIN (Harus Ditolak)
     * =====================================================================
     */
    public function test_student_cannot_access_admin_pages()
    {
        /** @var \App\Models\User $student */
        $student = User::factory()->create(['role' => 'mahasiswa']);
        $this->actingAs($student);

        // Buat dummy item untuk parameter rute
        $item = Item::create([
            'kode_alat' => 'SEC-001', 'nama_alat' => 'Secret Item', 'jumlah_total' => 1, 'stok_dipinjam' => 0
        ]);

        // Daftar Rute Admin Terlarang
        $forbiddenRoutes = [
            route('dashboard_admin'),
            route('barang.create'),
            route('barang.edit', $item->id), // Coba edit barang
            route('barang.cetak'),           // Coba cetak laporan
            route('peminjaman'),             // Coba lihat daftar peminjam lain
            route('members.index'),          // Coba lihat data user lain
        ];

        foreach ($forbiddenRoutes as $route) {
            $response = $this->get($route);
            // Harusnya 403 (Forbidden) karena Middleware IsAdmin
            $response->assertStatus(403);
        }
    }

    /**
     * =====================================================================
     * 4. TEST KEAMANAN: ADMIN MENCOBA JADI MAHASISWA (Harus Ditolak)
     * =====================================================================
     */
    public function test_admin_cannot_access_student_pages()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $forbiddenRoutes = [
            route('student.dashboard'),
            route('student.loans'),
            route('student.loan.form'),
        ];

        foreach ($forbiddenRoutes as $route) {
            $response = $this->get($route);
            // Harusnya 403 (Forbidden) karena Middleware IsStudent
            $response->assertStatus(403);
        }
    }

    /**
     * =====================================================================
     * 5. TEST KEAMANAN: TAMU (GUEST) BELUM LOGIN
     * =====================================================================
     */
    public function test_guest_cannot_access_protected_pages()
    {
        // Tanpa $this->actingAs() -> Artinya belum login
        
        // Coba akses halaman admin
        $response = $this->get(route('dashboard_admin'));
        $response->assertRedirect(route('login')); // Harus dilempar ke login

        // Coba akses halaman mahasiswa
        $response = $this->get(route('student.dashboard'));
        $response->assertRedirect(route('login'));
    }
}