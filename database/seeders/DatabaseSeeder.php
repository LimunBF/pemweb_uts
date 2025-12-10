<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Item; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin Lab',
            'email' => 'admin@lab.com',
            'password' => bcrypt('password123'), // Password di-hash agar aman
            'role' => 'admin',                   
            'identity_number' => 'ADM001',       // NIP/Identitas
            'contact' => '08123456789'
        ]);

    }
}