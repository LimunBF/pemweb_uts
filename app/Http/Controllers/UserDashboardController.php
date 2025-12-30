<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor; 
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    // 1. Dashboard Utama
    public function index()
    {
        $items = Item::latest()->get();
        return view('user.dashboard', compact('items'));
    }

    // 2. Halaman Inventaris
    public function inventory()
    {
        $items = Item::orderBy('nama_alat', 'asc')->get();
        return view('user.inventory', compact('items'));
    }

    // 3. Halaman Pinjaman Saya
    public function myLoans(Request $request)
    {
        // 1. Query Dasar: Ambil peminjaman milik user yang login
        $query = Peminjaman::with('item')
                    ->where('user_id', Auth::id());

        // 2. Filter Status (Jika ada input status)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Filter Tanggal (Jika kedua tanggal diisi)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Filter berdasarkan range tanggal pinjam
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        // 4. Eksekusi Query (Urutkan dari yang terbaru)
        $rawLoans = $query->orderBy('created_at', 'desc')->get();

        // 5. Grouping Data (Agar tampil per "Surat/Kode")
        $groupedLoans = $rawLoans->groupBy(function ($item) {
            return $item->kode_peminjaman ?? 'SINGLE_' . $item->id;
        });

        // 6. Kirim ke View
        return view('user.my_loans', compact('groupedLoans'));
    }

    // 4. Form Peminjaman (FIX ERROR STOK READY)
    public function loanForm()
    {
        // Langkah 1: Ambil dulu semua barang yang statusnya 'Tersedia' dari database
        $allItems = Item::where('status_ketersediaan', 'Tersedia')
                     ->orderBy('nama_alat', 'asc')
                     ->get();

        // Langkah 2: Filter menggunakan PHP (karena stok_ready adalah Accessor)
        // Kita hanya ambil barang yang stok_ready-nya > 0
        $items = $allItems->filter(function($item) {
            return $item->stok_ready > 0;
        });
        
        return view('user.loan_form', compact('items'));
    }

    // 5. PROSES SIMPAN 
    public function storeLoan(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1|max:5',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.amount' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan' => 'nullable|string|max:255',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:2048', 
        ]);

        $user = Auth::user();
        // Gunakan ID Number (NIM/NIP) atau fallback ke ID User jika kosong
        $userIdNumber = $user->identity_number ?? $user->id; 
        
        $kodeUnik = $user->id . '-' . time() . '-' . rand(10, 99);
        
        // --- LOGIKA UPLOAD FILE (DENGAN NAMA BARU) ---
        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $ext = $file->getClientOriginalExtension();
            
            // Format Nama: Surat_Peminjaman_NIM_TIMESTAMP.ext
            // Contoh: Surat_Peminjaman_M0512345_17082344.pdf
            $customName = 'Surat_Peminjaman_' . $userIdNumber . '_' . time() . '.' . $ext;
            
            // Simpan dengan nama baru tersebut
            $filePath = $file->storeAs('surat_peminjaman', $customName, 'public');
        }

        foreach ($request->items as $itemData) {
            Peminjaman::create([
                'user_id' => $user->id,
                'item_id' => $itemData['item_id'],
                'amount' => $itemData['amount'], 
                'kode_peminjaman' => $kodeUnik, 
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'pending',
                'alasan' => $request->alasan,
                'file_surat' => $filePath, 
            ]);
        }

        return redirect()->route('student.loans')->with('success', 'Pengajuan berhasil dikirim!');
    }

    // CETAK SURAT 
    public function printSurat($id)
    {
        $currentLoan = Peminjaman::with(['item', 'user'])->findOrFail($id);
        if (!empty($currentLoan->file_surat)) {
            // Ambil path file dari storage
            $path = storage_path('app/public/' . $currentLoan->file_surat);
            // Cek apakah file fisiknya benar-benar ada di server
            if (file_exists($path)) {
                // Langsung download file aslinya (PDF/Gambar/Docx)
                return response()->download($path);
            } 
        }
        
        // 1. Grouping Logic
        if (!empty($currentLoan->kode_peminjaman)) {
            $groupLoans = Peminjaman::with('item')
                            ->where('kode_peminjaman', $currentLoan->kode_peminjaman)
                            ->get();
        } else {
            $groupLoans = collect([$currentLoan]);
        }
        $templatePath = resource_path('templates/Surat Peminjaman Alat.docx');
        $templateProcessor = new TemplateProcessor($templatePath);
        // Tentukan Label NIM/NIP
        $userRole = strtolower($currentLoan->user->role ?? 'mahasiswa');
        $label = ($userRole === 'dosen') ? 'NIP' : 'NIM';
        // Isi Data Diri
        $templateProcessor->setValue('label_id', $label);
        $templateProcessor->setValue('name', $currentLoan->user->name);
        $templateProcessor->setValue('id_number', $currentLoan->user->identity_number ?? '-');
        $templateProcessor->setValue('phone_number', $currentLoan->user->contact ?? '-');
        $templateProcessor->setValue('reason', $currentLoan->alasan ?? '-'); 
        // Isi Tanggal
        Carbon::setLocale('id');
        $templateProcessor->setValue('tgl_surat', Carbon::now()->isoFormat('D MMMM Y')); 
        $templateProcessor->setValue('start_date', Carbon::parse($currentLoan->tanggal_pinjam)->format('d/m/Y'));
        $templateProcessor->setValue('end_date', Carbon::parse($currentLoan->tanggal_kembali)->format('d/m/Y'));
        // Isi Tabel Barang
        $maxSlots = 5; 
        foreach(range(1, $maxSlots) as $i) {
            if (isset($groupLoans[$i-1])) {
                $loan = $groupLoans[$i-1];
                $templateProcessor->setValue("alat_$i", $loan->item->nama_alat);
                $templateProcessor->setValue("qty_$i", $loan->amount . ' Unit'); 
            } else {
                $templateProcessor->setValue("alat_$i", '');
                $templateProcessor->setValue("qty_$i", '');
            }
        }

        // Simpan & Download
        $nimUntukFile = $currentLoan->user->identity_number ?? 'USER-' . $currentLoan->user->id;
        $fileName = 'Surat_Peminjaman_' . $nimUntukFile . '_' . $currentLoan->id . '.docx';
        $tempPath = storage_path('app/public/temp/' . $fileName);
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }
        $templateProcessor->saveAs($tempPath);
        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }
}
