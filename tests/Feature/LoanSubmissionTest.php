<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanSubmissionTest extends TestCase
{
    use RefreshDatabase; 

    public function test_student_can_submit_loan_with_file_upload()
    {
        // 1. Simulasi Storage
        Storage::fake('public');

        // 2. Buat User dummy
        /** @var \App\Models\User $user */  // <--- TAMBAHKAN BARIS INI
        $user = User::factory()->create([
            'role' => 'mahasiswa', 
        ]);

        // 3. Buat Item dummy
        $item = Item::create([
            'kode_alat' => 'TEST-001',
            'nama_alat' => 'Kamera Test',
            'deskripsi' => 'Alat untuk testing',
            'jumlah_total' => 10,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Bebas',
        ]);

        // 4. Buat File Palsu
        $file = UploadedFile::fake()->create('surat_pengantar.pdf', 100); 

        // 5. Kirim data (POST) ke route yang BENAR
        // Sesuai web.php: Route::post('/loan-form', ...)->name('loan.store');
        // Prefix groupnya 'student.', jadi nama lengkapnya 'student.loan.store'
        $response = $this->actingAs($user)->post(route('student.loan.store'), [
            'items' => [
                [
                    'item_id' => $item->id,
                    'amount' => 2,
                ]
            ],
            'tanggal_pinjam' => now()->addDay()->format('Y-m-d'),
            'tanggal_kembali' => now()->addDays(3)->format('Y-m-d'),
            'alasan' => 'Keperluan Testing Unit',
            'file_surat' => $file, 
        ]);

        // 6. Assertions
        
        // A. Pastikan redirect ke halaman 'My Loans' (student.loans)
        $response->assertRedirect(route('student.loans')); 

        // B. Pastikan data masuk ke Database
        $this->assertDatabaseHas('peminjamans', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'amount' => 2,
            'alasan' => 'Keperluan Testing Unit',
            'status' => 'pending',
        ]);

        // C. Pastikan file tersimpan
        $files = Storage::disk('public')->files('surat_peminjaman');
        $this->assertNotEmpty($files, 'File surat tidak ditemukan di storage! Upload gagal.');
    }

    public function test_cannot_borrow_more_than_available_stock()
    {
        Storage::fake('public');
        
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'mahasiswa']);

        // Buat barang dengan STOK HANYA 2
        $item = Item::create([
            'kode_alat' => 'LTD-01',
            'nama_alat' => 'Barang Terbatas',
            'jumlah_total' => 2, // <--- Perhatikan ini
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Bebas',
        ]);

        // Coba pinjam 5 unit
        $response = $this->actingAs($user)->post(route('student.loan.store'), [
            'items' => [
                [
                    'item_id' => $item->id,
                    'amount' => 5, // <--- Melebihi stok
                ]
            ],
            'tanggal_pinjam' => now()->addDay()->format('Y-m-d'),
            'tanggal_kembali' => now()->addDays(3)->format('Y-m-d'),
            'alasan' => 'Testing Overlimit',
        ]);

        // Harapannya: Gagal dan kembali ke form dengan error
        $response->assertSessionHasErrors(); // Pastikan ada error session
        
        // Pastikan TIDAK masuk database
        $this->assertDatabaseMissing('peminjamans', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'amount' => 5
        ]);
    }
}