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
    public function myLoans()
    {
        $loans = Peminjaman::with('item')
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc') 
                    ->get();

        return view('user.my_loans', compact('loans'));
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
            'items.*.amount' => 'required|integer|min:1', // Validasi jumlah
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'alasan' => 'nullable|string|max:255',
        ]);

        $kodeUnik = Auth::id() . '-' . time() . '-' . rand(10, 99);

        // Looping array items
        foreach ($request->items as $itemData) {
            Peminjaman::create([
                'user_id' => Auth::id(),
                'item_id' => $itemData['item_id'],
                'amount' => $itemData['amount'], // Simpan jumlah
                'kode_peminjaman' => $kodeUnik, 
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'pending',
                'alasan' => $request->alasan,
            ]);
        }

        return redirect()->route('student.loans')->with('success', 'Pengajuan berhasil dikirim!');
    }

    // 6. CETAK SURAT 
    public function printSurat($id)
    {
        $currentLoan = Peminjaman::with(['item', 'user'])->findOrFail($id);

        // ... (kode ambil groupLoans sama seperti sebelumnya) ...
        if (!empty($currentLoan->kode_peminjaman)) {
            $groupLoans = Peminjaman::with('item')
                            ->where('kode_peminjaman', $currentLoan->kode_peminjaman)
                            ->get();
        } else {
            $groupLoans = collect([$currentLoan]);
        }

        // ... (kode cek template & data diri sama) ...
        $templatePath = storage_path('app/templates/Surat Peminjaman Alat.docx');
        $templateProcessor = new TemplateProcessor($templatePath);
        
        $templateProcessor->setValue('name', $currentLoan->user->name);
        $templateProcessor->setValue('id_number', $currentLoan->user->identity_number ?? '-');
        $templateProcessor->setValue('phone_number', $currentLoan->user->contact ?? '-');
        $templateProcessor->setValue('reason', $currentLoan->alasan ?? '-'); 

        // Isi Tanggal
        Carbon::setLocale('id');
        $templateProcessor->setValue('tgl_surat', Carbon::now()->isoFormat('D MMMM Y')); 
        $templateProcessor->setValue('start_date', Carbon::parse($currentLoan->tanggal_pinjam)->format('d/m/Y'));
        $templateProcessor->setValue('end_date', Carbon::parse($currentLoan->tanggal_kembali)->format('d/m/Y'));

        // --- ISI DATA BARANG & QUANTITY ---
        $maxSlots = 5; 
        
        foreach(range(1, $maxSlots) as $i) {
            if (isset($groupLoans[$i-1])) {
                $loan = $groupLoans[$i-1]; // Ambil objek peminjaman
                
                $templateProcessor->setValue("alat_$i", $loan->item->nama_alat);
                // AMBIL JUMLAH DARI DATABASE
                $templateProcessor->setValue("qty_$i", $loan->amount . ' Unit'); 
            } else {
                $templateProcessor->setValue("alat_$i", '');
                $templateProcessor->setValue("qty_$i", '');
            }
        }

        // ... (kode download sama) ...
        $fileName = 'Surat_Peminjaman_' . ($currentLoan->user->identity_number ?? 'MHS') . '_' . $id . '.docx';
        $tempPath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}