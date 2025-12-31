<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FullSystemTest extends TestCase
{
    // Menggunakan RefreshDatabase agar setiap test mulai dengan database bersih
    use RefreshDatabase;

    /**
     * TEST 1: HALAMAN PUBLIK (LANDING PAGE)
     */
    public function test_guest_sees_landing_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang'); 
        $response->assertSee('Mulai Pinjam');
    }

    /**
     * TEST 2: AUTENTIKASI (REGISTER & LOGIN)
     */
    public function test_new_user_can_register_and_login()
    {
        // 1. Coba Register
        $response = $this->post('/register', [
            'name' => 'Mahasiswa Test',
            'email' => 'mhs@test.com',
            'contact' => '08123456789',
            'role' => 'mahasiswa',
            'identity_number_mhs' => 'M0512345',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('student.dashboard'));
        $this->assertAuthenticated();

        // 2. Coba Logout
        $this->post('/logout');
        $this->assertGuest();

        // 3. Coba Login Kembali
        $response = $this->post('/login', [
            'email' => 'mhs@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('student.dashboard'));
    }

    /**
     * TEST 3: ADMIN INVENTORY (CRUD BARANG)
     */
    public function test_admin_can_manage_inventory()
    {
        // Buat User Admin & Beri Type Hint agar IDE tidak error
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@lab.com'
        ]);

        // Login sebagai Admin
        $this->actingAs($admin);

        // A. CREATE (Tambah Barang)
        $response = $this->post(route('barang.store'), [
            'kode_alat' => 'LAB-001',
            'nama_alat' => 'Laptop Gaming ROG',
            'jumlah_total' => 5,
            'deskripsi' => 'Laptop untuk render',
        ]);
        
        $response->assertRedirect(route('barang.index'));
        $this->assertDatabaseHas('items', ['kode_alat' => 'LAB-001']);

        $item = Item::where('kode_alat', 'LAB-001')->first();

        // B. UPDATE (Edit Barang)
        $response = $this->put(route('barang.update', $item->id), [
            'kode_alat' => 'LAB-001',
            'nama_alat' => 'Laptop Gaming ROG Updated',
            'jumlah_total' => 10,
            'status_ketersediaan' => 'Tersedia',
            'deskripsi' => 'Updated deskripsi'
        ]);
        
        $this->assertDatabaseHas('items', ['nama_alat' => 'Laptop Gaming ROG Updated']);

        // C. DELETE (Hapus Barang)
        $response = $this->delete(route('barang.destroy', $item->id));
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    /**
     * TEST 4: SKENARIO PEMINJAMAN LENGKAP (FLOW UTAMA)
     */
    public function test_full_loan_lifecycle()
    {
        // ... (setup data admin, student, item tidak berubah) ...
        
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin Lab']);
        
        /** @var \App\Models\User $student */
        $student = User::factory()->create(['role' => 'mahasiswa', 'name' => 'Budi MHS']);
        
        $item = Item::create([
            'kode_alat' => 'CAM-001',
            'nama_alat' => 'Kamera Sony Alpha',
            'jumlah_total' => 3,
            'stok_dipinjam' => 0,
            'deskripsi' => 'Kamera Mirrorless',
            'status_ketersediaan' => 'Tersedia'
        ]);

        // --- STEP 1: MAHASISWA PINJAM ---
        $this->actingAs($student); 
        
        $response = $this->post(route('student.loan.store'), [
            'items' => [
                [
                    'item_id' => $item->id,
                    'amount' => 1
                ]
            ],
            'tanggal_pinjam' => now()->addDay()->format('Y-m-d'),
            'tanggal_kembali' => now()->addDays(3)->format('Y-m-d'),
            'alasan' => 'Untuk tugas fotografi',
        ]);

        $response->assertRedirect(route('student.loans'));
        
        // [PERBAIKAN DISINI] Ganti 'peminjamen' jadi 'peminjamans'
        $this->assertDatabaseHas('peminjamans', [
            'user_id' => $student->id,
            'item_id' => $item->id,
            'status' => 'pending'
        ]);

        // --- STEP 2: ADMIN APPROVAL ---
        $this->actingAs($admin); 
        
        $loan = Peminjaman::where('user_id', $student->id)->first();

        $response = $this->patch(route('peminjaman.update', $loan->id), [
            'status' => 'disetujui'
        ]);

        // [PERBAIKAN DISINI JUGA] Ganti 'peminjamen' jadi 'peminjamans'
        $this->assertDatabaseHas('peminjamans', [
            'id' => $loan->id,
            'status' => 'disetujui'
        ]);
    }
}