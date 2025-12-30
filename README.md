# 📦 Sistem Informasi Peminjaman & Inventaris Barang (Lab PTIK)

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat&logo=tailwind-css)
![SweetAlert2](https://img.shields.io/badge/SweetAlert2-v11-purple?style=flat&logo=sweetalert2)
![Chart.js](https://img.shields.io/badge/Chart.js-v4-orange?style=flat&logo=chart.js)
![Status](https://img.shields.io/badge/Status-Completed-success)

## 📖 Deskripsi Projek

Aplikasi ini adalah sistem berbasis web yang dibangun menggunakan framework **Laravel** untuk memfasilitasi proses peminjaman alat/barang dan pengelolaan inventaris di Laboratorium PTIK.

Sistem ini dirancang dengan fokus pada **User Experience (UX)** yang modern dan interaktif. Tidak hanya sekadar mencatat, aplikasi ini dilengkapi dengan dashboard analitik visual, notifikasi interaktif, dan antarmuka yang ramah pengguna.

Projek ini dikembangkan sebagai bagian dari tugas **Pemrograman Web (UAS)**.

## 👥 Tim Pengembang (Limun United)

Berikut adalah anggota tim yang berkontribusi dalam pengembangan aplikasi ini:

| Nama Mahasiswa | NIM | Peran / Kontribusi |
| :--- | :--- | :--- |
| **Lintang Mukti Nugroho** | K3522040 | Fullstack / Backend / Setup Awal |
| **Zahra 'Arf Walidain** | K3522084 | Frontend / UI Design / Illustration |
| **Dita Nofiana** | K3522022 | Database / Testing / Validation |
| **Dian Fitri Utami** | K3522019 | Dokumentasi / Fitur Laporan / QA |

## 🚀 Fitur Unggulan

### ✨ UI/UX Modern (New!)
* **Landing Page Informatif:** Halaman depan profesional dengan penjelasan fitur.
* **Interactive Auth:** Halaman Login & Register dengan maskot kucing animasi (mengikuti kursor & tutup mata saat ketik password).
* **Visualisasi Data:** Dashboard Admin dilengkapi Grafik Tren Peminjaman (Line Chart) dan Status Aset (Doughnut Chart).
* **Smart Feedback:** Menggunakan **SweetAlert2** untuk konfirmasi dan notifikasi yang lebih elegan.
* **Skeleton Loading:** Efek pemuatan data yang halus menggantikan loading spinner konvensional.
* **Empty States:** Ilustrasi menarik saat data kosong.

### 👮 Fitur Administrator
1.  **Dashboard Admin:** Ringkasan statistik realtime dan grafik performa lab.
2.  **Manajemen Barang (Inventory):** CRUD lengkap (Foto, Stok, Kondisi) dengan pencarian cepat.
3.  **Manajemen Peminjaman:**
    * Approval System (Setujui/Tolak) dengan sekali klik.
    * Monitoring status barang (Dipinjam/Terlambat/Kembali).
    * Cetak Laporan Bulanan.
4.  **Manajemen Member:** Mengelola data pengguna (Dosen & Mahasiswa).

### 👤 Fitur User (Mahasiswa/Dosen)
1.  **Katalog Barang:** Cek ketersediaan alat secara realtime.
2.  **Pengajuan Peminjaman:** Form peminjaman yang mudah dengan validasi otomatis.
3.  **Riwayat Peminjaman:** Pantau status pengajuan dan histori peminjaman.
4.  **Cetak Bukti:** Unduh surat bukti peminjaman untuk pengambilan barang.

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP 8.2+ (Laravel 11)
* **Frontend:** Blade Templating, Tailwind CSS
* **Interactive Libs:** SweetAlert2, Chart.js, Alpine.js
* **Database:** MySQL
* **Tools:** Composer, NPM, Git

## 💻 Cara Instalasi & Menjalankan Projek

Ikuti langkah-langkah berikut untuk menjalankan projek di komputer lokal (Localhost).

### Prasyarat
Pastikan komputer Anda sudah terinstall:
* PHP >= 8.2
* Composer
* Node.js & NPM
* Database Server (MySQL/MariaDB via Laragon/XAMPP)

### Langkah-langkah

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/limunbf/pemweb_uts.git](https://github.com/limunbf/pemweb_uts.git)
    cd pemweb_uts
    ```

2.  **Install Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment (.env)**
    ```bash
    cp .env.example .env
    ```
    *Sesuaikan konfigurasi database (DB_DATABASE, DB_USERNAME, dll) di file .env.*

4.  **Generate App Key**
    ```bash
    php artisan key:generate
    ```

5.  **Migrasi Database & Seeding**
    ```bash
    php artisan migrate:fresh --seed
    ```
    *(Ini akan membuat tabel dan mengisi data dummy awal)*

6.  **Setup Storage Link**
    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Aplikasi**
    Buka dua terminal berbeda:
    *Terminal 1:*
    ```bash
    php artisan serve
    ```
    *Terminal 2:*
    ```bash
    npm run dev
    ```

8.  **Akses Aplikasi**
    Buka browser: `http://127.0.0.1:8000`

## 🔑 Akun Default (Seeder)

Gunakan akun berikut untuk masuk:

* **Admin (Superuser):**
    * Email: `admin@lab.com`
    * Password: `password123`
* **User (Mahasiswa):**
    * Email: `siti@mhs.com`
    * Password: `password123`

---
Dibuat dengan ❤️ oleh **Kelompok Limun United**.
