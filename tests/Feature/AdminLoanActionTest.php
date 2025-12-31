<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminLoanActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_loan()
    {
        // 1. Setup Data: User, Item, dan Peminjaman Pending
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        /** @var \App\Models\User $student */
        $student = User::factory()->create(['role' => 'mahasiswa']);
        
        $item = Item::create([
            'kode_alat' => 'CAM-01',
            'nama_alat' => 'Kamera DSLR',
            'jumlah_total' => 5,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Bebas'
        ]);

        // Buat peminjaman status 'pending'
        $loan = Peminjaman::create([
            'user_id' => $student->id,
            'item_id' => $item->id,
            'amount' => 1,
            'kode_peminjaman' => 'LOAN-TEST-001', // Kode unik
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(2),
            'status' => 'pending',
        ]);

        // 2. Action: Admin melakukan update status ke 'disetujui'
        // Route di web.php: Route::patch('/peminjaman/{id}', ...)->name('peminjaman.update');
        $response = $this->actingAs($admin)
                         ->patch(route('peminjaman.update', $loan->id), [
                             'status' => 'disetujui'
                         ]);

        // 3. Assertions
        // Cek redirect sukses
        $response->assertSessionHas('success'); 
        
        // Cek database berubah jadi 'disetujui'
        $this->assertDatabaseHas('peminjamans', [
            'id' => $loan->id,
            'status' => 'disetujui',
            'approver_id' => $admin->id, // Pastikan ID admin tercatat sebagai approver
        ]);
    }

    public function test_student_cannot_approve_loan()
    {
        // 1. Buat User Mahasiswa
        /** @var \App\Models\User $student */
        $student = User::factory()->create(['role' => 'mahasiswa']);
        
        // 2. PERBAIKAN: Buat Item terlebih dahulu agar ID-nya valid di database
        $item = Item::create([
            'kode_alat' => 'HACK-01',
            'nama_alat' => 'Barang Dummy',
            'jumlah_total' => 5,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Bebas'
        ]);

        // 3. Buat Peminjaman dengan ID item yang valid
        $loan = Peminjaman::create([
            'user_id' => $student->id,
            'item_id' => $item->id, // <-- Gunakan ID dari item yang baru dibuat
            'amount' => 1,
            'kode_peminjaman' => 'LOAN-HACK',
            'status' => 'pending',
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now()->addDays(2),
        ]);

        // 4. Action: Mahasiswa mencoba 'approve' (harusnya gagal/tidak berubah)
        $this->actingAs($student)
             ->patch(route('peminjaman.update', $loan->id), [
                 'status' => 'disetujui'
             ]);

        // 5. Assertion: Pastikan status TETAP pending (tidak berubah jadi disetujui)
        // Jika test ini gagal (status berubah jadi disetujui), berarti route Anda belum diproteksi middleware admin
        $this->assertNotEquals('disetujui', $loan->refresh()->status, 'BAHAYA: Mahasiswa berhasil meng-approve peminjaman!');
    }
}