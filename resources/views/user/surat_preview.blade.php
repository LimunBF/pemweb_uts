<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Surat Peminjaman</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* SETUP HALAMAN */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; -webkit-print-color-adjust: exact; }
            .paper { box-shadow: none !important; margin: 0 !important; width: 100% !important; padding: 0 !important; }
            @page { size: A4 portrait; margin: 2cm; } 
        }

        body {
            background-color: #525659;
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 2rem 0;
            display: flex;
            justify-content: center;
        }

        .paper {
            width: 210mm;
            min-height: 297mm;
            background-color: white;
            padding: 2cm 2.5cm; /* Margin Atas/Bawah 2cm, Kiri/Kanan 2.5cm */
            position: relative;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            line-height: 1.15;
            font-size: 12pt;
            color: #000;
        }

        /* PERBAIKAN KOP SURAT */
        .kop-container {
            position: relative
            width: 100%;
            border-bottom: 3px double black; /* Garis ganda */
            padding-bottom: 10px;
            margin-bottom: 25px;
            text-align: center; 
        }

        .kop-logo {
            position: absolute;
            top: 50px;   /* Sesuaikan tinggi logo */
            left: 25px;    /* Tempel di kiri */
            width: 2.2cm;
            height: auto;
        }

        .kop-text {
            width: 100%; 
            margin: 0 auto;
        }

        .kop-kementrian { font-size: 11pt; }
        .kop-univ { font-size: 11pt; font-weight: bold; }
        .kop-fakultas { font-size: 11pt; font-weight: bold; }
        .kop-prodi { font-size: 12pt; font-weight: bold; }
        .kop-alamat { font-size: 9pt; }

        /* TABEL & LIST */
        table { width: 100%; vertical-align: top; border-collapse: collapse; }
        td { vertical-align: top; padding: 1px 0; }
        
        /* TANDA TANGAN */
        .ttd-area {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
        }
        .ttd-box { width: 45%; text-align: center; }
        .ttd-space { height: 70px; }

        /* LIST BARANG */
        .list-barang-table td { padding: 2px 5px; }
        .list-barang-table tr td:first-child { width: 30px; text-align: center; }
    </style>
</head>
<body>

    {{-- NAVIGASI --}}
    <div class="no-print fixed top-0 left-0 w-full bg-slate-800 text-white p-3 flex justify-between items-center shadow-md z-50 font-sans">
        <span class="font-bold text-sm tracking-wide">PREVIEW DOKUMEN</span>
        <div class="flex gap-2">
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-1.5 rounded text-sm font-bold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak PDF
            </button>
            <button onclick="window.close()" class="bg-red-600 hover:bg-red-500 text-white px-4 py-1.5 rounded text-sm font-bold">
                Tutup
            </button>
        </div>
    </div>

    {{-- KERTAS KERJA --}}
    <div class="paper">
        <div class="kop-container">
            <img src="{{ asset('templates/logo.png') }}" alt="Logo UNS" class="kop-logo">
            
            <div class="kop-text uppercase">
                <div class="kop-univ">UNIVERSITAS SEBELAS MARET</div>
                <div class="kop-fakultas">FAKULTAS KEGURUAN DAN ILMU PENDIDIKAN</div>
                <div class="kop-prodi">LABORATORIUM PENDIDIKAN TEKNIK INFORMATIKA DAN KOMPUTER</div>
                <div class="kop-alamat" style="text-transform: none; font-style: italic; margin-top: 2px;">
                    Jl. Jend. Ahmad Yani 200 Pabelan Kartasura Sukoharjo 57161 Telp/Fax (0271) 648939<br>
                    Website: http://ptik.fkip.uns.ac.id Email: ptik@fkip.uns.ac.id
                </div>
            </div>
        </div>

        <table style="margin-bottom: 20px;">
            <tr>
                <td style="width: 80px;">Nomor</td>
                <td style="width: 10px;">:</td>
                <td>32/A/UN27.02.3.14.1/MIKROPTIK/PA/IX/{{ date('Y') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td colspan="2">-</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td colspan="2"><strong>Permohonan Peminjaman Alat</strong></td>
            </tr>
        </table>

        <div style="margin-bottom: 20px;">
            Yth. Kepala Laboratorium Pendidikan Teknik Informatika dan Komputer<br>
            Fakultas Keguruan dan Ilmu Pendidikan<br>
            Universitas Sebelas Maret
        </div>

        <div style="margin-bottom: 10px;">Dengan hormat,</div>
        <div style="text-align: justify; margin-bottom: 10px;">
            Bersama dengan surat ini, saya mahasiswa PTIK FKIP UNS yang bernama:
        </div>

        <table style="margin-left: 30px; margin-bottom: 15px; width: auto;">
            <tr>
                <td style="width: 120px;">Nama</td>
                <td style="width: 10px;">:</td>
                <td><strong>{{ $user->name }}</strong></td>
            </tr>
            <tr>
                <td>{{ $label_id }}</td>
                <td>:</td>
                <td>{{ $user->identity_number ?? '-' }}</td>
            </tr>
            <tr>
                <td>No Telepon</td>
                <td>:</td>
                <td>{{ $user->contact ?? '-' }}</td>
            </tr>
        </table>

        <div style="text-align: justify; margin-bottom: 10px;">
            bermaksud meminjam alat – alat yang ada di LAB PTIK FKIP UNS pada:
        </div>

        <table style="margin-left: 30px; margin-bottom: 15px; width: auto;">
            <tr>
                <td style="width: 120px;">Tanggal</td>
                <td style="width: 10px;">:</td>
                <td>
                    {{ \Carbon\Carbon::parse($peminjaman->first()->tanggal_pinjam)->translatedFormat('d F Y') }} 
                    s.d. 
                    {{ \Carbon\Carbon::parse($peminjaman->first()->tanggal_kembali)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        <div style="text-align: justify; margin-bottom: 10px;">
            Sehubungan dengan hal tersebut, kami bermaksud memohon izin meminjam alat – alat tersebut yang akan saya gunakan untuk <strong>[ {{ $peminjaman->first()->alasan }} ]</strong>. Adapun alat dan perlengkapan yang akan dipergunakan adalah sebagai berikut:
        </div>

        {{-- DAFTAR BARANG --}}
        <div style="margin-left: 30px; margin-bottom: 20px;">
            <table class="list-barang-table">
                @foreach($items as $index => $loan)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td>{{ $loan->item->nama_alat }}</td>
                    <td>- {{ $loan->amount }} Unit</td>
                </tr>
                @endforeach
            </table>
        </div>

        <div style="text-align: justify; margin-bottom: 30px;">
            Demikian surat permohonan ini kami sampaikan. Atas perhatian dan pemberian izin Bapak kami mengucapkan terima kasih.
        </div>

        <div class="ttd-area">
            <div class="ttd-box">
                <br>Mengetahui,<br>Kepala Laboratorium PTIK FKIP UNS
                <div class="ttd-space"></div>
                <strong><u>Yusfia Hafid A, S.T., M.T.</u></strong><br>
                NIP. 19910524 201903 1 016
            </div>

            <div class="ttd-box">
                Surakarta, {{ $today }}<br>Hormat Saya,<br>Pemohon
                <div class="ttd-space"></div>
                <strong><u>{{ $user->name }}</u></strong><br>
                {{ $label_id }}. {{ $user->identity_number ?? '................' }}
            </div>
        </div>

    </div>

</body>
</html>