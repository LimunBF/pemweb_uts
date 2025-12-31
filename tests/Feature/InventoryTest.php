<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_new_item()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        // Data barang baru
        $itemData = [
            'kode_alat' => 'LPT-001',
            'nama_alat' => 'Laptop Asus ROG',
            'deskripsi' => 'Laptop Gaming untuk praktikum',
            'jumlah_total' => 10,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Bebas',
        ];

        // Post ke route barang.store (Resource items)
        $response = $this->actingAs($admin)->post(route('items.store'), $itemData);

        $response->assertRedirect();
        $this->assertDatabaseHas('items', ['kode_alat' => 'LPT-001']);
    }

    public function test_admin_can_update_item_stock()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        
        $item = Item::create([
            'kode_alat' => 'OLD-01',
            'nama_alat' => 'Barang Lama',
            'jumlah_total' => 5,
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Bebas'
        ]);

        // Update jumlah jadi 20
        $response = $this->actingAs($admin)->put(route('items.update', $item->id), [
            'kode_alat' => 'OLD-01',
            'nama_alat' => 'Barang Lama (Updated)',
            'jumlah_total' => 20, // <-- Stok bertambah
            'status_ketersediaan' => 'Tersedia',
            'status_tugas' => 'Bebas',
            'deskripsi' => 'Update stok'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'jumlah_total' => 20
        ]);
    }
}