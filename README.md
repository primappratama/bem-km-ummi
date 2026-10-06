<div align="center">
<br/>

<img src="public/images/logo.png" width="72" alt="BEM KM UMMI" />

<br/>
<br/>

# bem-km-ummi

**Aplikasi pengelolaan administrasi dan kegiatan BEM KM**  
Universitas Muhammadiyah Sukabumi · Kabinet Revolusioner 2025/2026

<br/>

![](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![](https://img.shields.io/badge/PHP-8.4-8892BF?style=flat-square&logo=php&logoColor=white)
![](https://img.shields.io/badge/MySQL-8.0-00758F?style=flat-square&logo=mysql&logoColor=white)
![](https://img.shields.io/badge/Tailwind_CSS-v3-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)

<br/>

</div>

---

## Tentang Proyek

Platform web terpusat untuk mengelola seluruh administrasi BEM KM UMMI — menggantikan WhatsApp, spreadsheet, dan Drive yang tersebar jadi satu sistem yang terintegrasi.

**Modul yang tersedia:**

| Modul         | Deskripsi                                                |
| ------------- | -------------------------------------------------------- |
| Dashboard     | Monitoring real-time: saldo, proker, pengurus, aspirasi  |
| Pengurus      | Manajemen anggota per kementerian                        |
| Kementerian   | CRUD kementerian & struktur organisasi                   |
| Program Kerja | Kelola kegiatan, filter status per kementerian           |
| Keuangan      | Catat transaksi masuk/keluar, export laporan PDF         |
| Absensi       | Catat kehadiran per kegiatan, rekap per pengurus         |
| Aspirasi      | Form publik tanpa login, kelola & update status di admin |
| Dokumen LPJ   | Unggah & unduh arsip laporan pertanggungjawaban          |
| Profil Publik | Edit visi misi langsung dari panel admin                 |
| Pengaturan    | Ubah username & password tiap akun                       |

**Hak akses (RBAC):**

|                        | Admin | Sekretaris | Bendahara | Kementerian |
| ---------------------- | :---: | :--------: | :-------: | :---------: |
| Pengurus & Kementerian |   ✓   |     ✓      |     —     |      —      |
| Program Kerja          |   ✓   |     ✓      |     —     |      ✓      |
| Keuangan               |   ✓   |     —      |     ✓     |      —      |
| Absensi & Dokumen LPJ  |   ✓   |     ✓      |     —     |      ✓      |
| Aspirasi               |   ✓   |     ✓      |     —     |      —      |
| Profil Publik          |   ✓   |     —      |     —     |      —      |

---

## Stack

```
Backend    Laravel 12 (PHP 8.4)
Frontend   Blade · Tailwind CSS v3
Database   MySQL 8
Auth       Laravel Auth + RBAC Middleware
Dev        Laragon
```

---

## Setup

**1. Clone & install**

```bash
git clone https://github.com/primappratama/bem-km-ummi.git
cd bem-km-ummi
composer install && npm install
```

**2. Environment**

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuaikan database:

```env
DB_DATABASE=bem_km_ummi
DB_USERNAME=root
DB_PASSWORD=
```

**3. Migrate & seed**

```bash
php artisan migrate --seed
```

Seeder otomatis membuat 7 kementerian, visi misi, 3 akun demo, 19 pengurus, dan 19 program kerja.

**4. Jalankan**

```bash
npm run build
php artisan serve
```

Buka `http://127.0.0.1:8000`

---

## Akun Demo

| Username     | Password   | Role        |
| ------------ | ---------- | ----------- |
| `admin`      | `password` | Super Admin |
| `sekretaris` | `password` | Sekretaris  |
| `bendahara`  | `password` | Bendahara   |

> Ganti password setelah login pertama via `/admin/pengaturan`

---

## Struktur Database

```
users           akun & role
kementerian     data kementerian BEM
pengurus        anggota BEM → users, kementerian
program_kerja   kegiatan → kementerian
keuangan        transaksi → users, program_kerja
absensi         kehadiran → pengurus, program_kerja
aspirasi        masukan mahasiswa (standalone)
dokumen_lpj     arsip LPJ → users, program_kerja
settings        visi, misi, deskripsi
```

---

<div align="center">

Dikembangkan oleh **Siti Rohmah Ramadhanti** `2330511013` & **Prima Pratama Putra** `2330511022`  
Program Studi Teknik Informatika · UMMI · 2026

<br/>

_"Menghidupkan tradisi intelektual, advokasi, dan gerakan mahasiswa yang kritis, kolaboratif, dan progresif."_

</div>
