<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // <--- PENTING: Tambahkan ini untuk kirim request
use Illuminate\Support\Facades\Log;  // <--- Tambahkan ini untuk logging error
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi (Sama seperti sebelumnya)
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contact' => [
                'required', 'numeric', 'digits_between:10,13', 'regex:/^08[0-9]+$/', 
                'unique:users,contact,' . $user->id
            ],
            'password' => 'nullable|min:6|confirmed', 
        ], [
            // ... (pesan error sama seperti sebelumnya) ...
            'email.unique' => 'Email ini sudah digunakan.',
            'contact.regex' => 'Format nomor HP harus diawali "08".',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // 2. Siapkan Data
        $data = [
            'email'   => $request->email,
            'contact' => $request->contact,
        ];

        $passwordChanged = false;
        $plainPassword = null;

        // 3. Cek Password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $passwordChanged = true;
            $plainPassword = $request->password;
        }

        // 4. Update Database
        /** @var \App\Models\User $user */
        $user->update($data);

        // 5. Kirim Notifikasi WhatsApp (Jika Password Berubah)
        if ($passwordChanged) {
            // Kita bungkus dalam try-catch agar jika WA gagal, web tidak ikut error/crash
            try {
                $this->sendWhatsAppNotification($user->contact, $user->name, $plainPassword);
            } catch (\Exception $e) {
                // Jika gagal kirim WA, catat di log saja, jangan hentikan aplikasi
                Log::error("Gagal kirim WA ke {$user->contact}: " . $e->getMessage());
            }
        }

        return redirect()->route('student.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    // --- FUNGSI ASLI KIRIM WA (FONNTE) ---
    private function sendWhatsAppNotification($targetPhone, $name, $newPassword)
    {
        // 1. Ambil Token dari .env
        $token = env('FONNTE_TOKEN'); 

        // 2. Format Pesan
        $message = "*SISTEM INVENTARIS LAB PTIK*\n\n"
                 . "Halo *$name*,\n"
                 . "Password akun Anda baru saja diubah.\n\n"
                 . "🔐 Password Baru: *$newPassword*\n\n"
                 . "Jika Anda tidak merasa melakukan perubahan ini, segera hubungi Admin.\n"
                 . "Terima kasih.";

        // 3. Kirim Request ke API Fonnte
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $targetPhone, // Fonnte otomatis mendeteksi 08.. atau 62..
            'message' => $message,
            'countryCode' => '62', // Default negara Indonesia
        ]);

        // 4. Cek Response (Opsional, untuk debugging di Log Laravel)
        if ($response->successful()) {
            Log::info("WA Terkirim ke {$targetPhone}");
        } else {
            Log::error("Fonnte Error: " . $response->body());
        }
    }
}