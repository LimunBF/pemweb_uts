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
        $query = Peminjaman::with('item')
                    ->where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }
        $rawLoans = $query->orderBy('created_at', 'desc')->get();
        $groupedLoans = $rawLoans->groupBy(function ($item) {
            return $item->kode_peminjaman ?? 'SINGLE_' . $item->id;
        });
        return view('user.my_loans', compact('groupedLoans'));
    }

    public function loanForm()
    {
        $allItems = Item::where('status_ketersediaan', 'Tersedia')
                     ->orderBy('nama_alat', 'asc')
                     ->get();
        $items = $allItems->filter(function($item) {
            return $item->stok_ready > 0;
        });
        
        return view('user.loan_form', compact('items'));
    }
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

        foreach ($request->items as $itemData) {
            $itemDB = Item::find($itemData['item_id']);
            if (!$itemDB || $itemDB->stok_ready < $itemData['amount']) {
                $namaBarang = $itemDB ? $itemDB->nama_alat : 'Barang tidak ditemukan';
                $sisaStok = $itemDB ? $itemDB->stok_ready : 0;
                return back()
                    ->withErrors(['items' => "Stok '{$namaBarang}' tidak mencukupi! (Tersedia: {$sisaStok}, Diminta: {$itemData['amount']})"])
                    ->withInput(); 
            }
        }

        $user = Auth::user();
        $userIdNumber = $user->identity_number ?? $user->id; 
        
        $kodeUnik = $user->id . '-' . time() . '-' . rand(10, 99);
        
        $filePath = null;
        if ($request->hasFile('file_surat')) {
            $file = $request->file('file_surat');
            $ext = $file->getClientOriginalExtension();
            $customName = 'Surat_Peminjaman_' . $userIdNumber . '_' . time() . '.' . $ext;
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
            $path = storage_path('app/public/' . $currentLoan->file_surat);
            if (file_exists($path)) {
                return response()->download($path);
            } 
        }
        
        if (!empty($currentLoan->kode_peminjaman)) {
            $groupLoans = Peminjaman::with('item')
                            ->where('kode_peminjaman', $currentLoan->kode_peminjaman)
                            ->get();
        } else {
            $groupLoans = collect([$currentLoan]);
        }
        $templatePath = resource_path('templates/Surat Peminjaman Alat.docx');
        $templateProcessor = new TemplateProcessor($templatePath);
        $userRole = strtolower($currentLoan->user->role ?? 'mahasiswa');
        $label = ($userRole === 'dosen') ? 'NIP' : 'NIM';
        $templateProcessor->setValue('label_id', $label);
        $templateProcessor->setValue('name', $currentLoan->user->name);
        $templateProcessor->setValue('id_number', $currentLoan->user->identity_number ?? '-');
        $templateProcessor->setValue('phone_number', $currentLoan->user->contact ?? '-');
        $templateProcessor->setValue('reason', $currentLoan->alasan ?? '-'); 
        Carbon::setLocale('id');
        $templateProcessor->setValue('tgl_surat', Carbon::now()->isoFormat('D MMMM Y')); 
        $templateProcessor->setValue('start_date', Carbon::parse($currentLoan->tanggal_pinjam)->format('d/m/Y'));
        $templateProcessor->setValue('end_date', Carbon::parse($currentLoan->tanggal_kembali)->format('d/m/Y'));
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

        $nimUntukFile = $currentLoan->user->identity_number ?? 'USER-' . $currentLoan->user->id;
        $fileName = 'Surat_Peminjaman_' . $nimUntukFile . '_' . $currentLoan->id . '.docx';
        $tempPath = storage_path('app/public/temp/' . $fileName);
        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }
        $templateProcessor->saveAs($tempPath);
        return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);
    }

    public function guide()
    {
        return view('user.guide');
    }
}
