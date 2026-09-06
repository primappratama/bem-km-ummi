<?php
// Jalankan via: php artisan tinker < seeder_pengurus.php

use App\Models\Kementerian;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// ─── Helper ───────────────────────────────────────────────────────────────────
function buatPengurus($kemId, $nama, $jabatan, $kontak = null) {
    // Buat user login dulu
    $email = strtolower(str_replace(' ', '.', $nama)) . '@bemkm.ac.id';
    $user = User::firstOrCreate(
        ['email' => $email],
        [
            'name'     => $nama,
            'password' => Hash::make('password'),
            'role'     => $kemId ? 'kementerian' : 'super_admin',
        ]
    );

    Pengurus::firstOrCreate(
        ['user_id' => $user->id],
        [
            'kementerian_id' => $kemId,
            'nama'           => $nama,
            'jabatan'        => $jabatan,
            'kontak'         => $kontak,
        ]
    );

    echo "✓ $nama — $jabatan\n";
}

// ─── PENGURUS INTI (tanpa kementerian) ───────────────────────────────────────
buatPengurus(null, 'Vicran Patinailaya Namadula', 'Presiden BEM');
buatPengurus(null, 'Muhamad Balyan', 'Wakil Presiden BEM');

// ─── PER KEMENTERIAN ─────────────────────────────────────────────────────────
$kemList = Kementerian::orderBy('id')->get()->keyBy('kode');

// KEMENLU
if ($k = $kemList->get('KEMENLU')) {
    buatPengurus($k->id, 'Saddam Syahrul Rifaldi', 'Menteri');
    buatPengurus($k->id, 'Fadhil Ahmad Fauzan',    'Biro');
}

// KEMENDIKIL / KEMENDIKIL — coba beberapa kemungkinan kode
$kemendikil = $kemList->get('KEMENDIKIL') ?? $kemList->get('DIKIL') ?? $kemList->first(fn($k) => str_contains(strtolower($k->nama_kementerian), 'pendidikan'));
if ($kemendikil) {
    buatPengurus($kemendikil->id, 'Senja Maulana Ispahan', 'Menteri');
    buatPengurus($kemendikil->id, 'Syahfirizqi Azmi',      'Biro');
}

// KEMENKOMINFO
$kominfo = $kemList->get('KEMENKOMINFO') ?? $kemList->get('KOMINFO') ?? $kemList->first(fn($k) => str_contains(strtolower($k->nama_kementerian), 'kominfo') || str_contains(strtolower($k->nama_kementerian), 'komunikasi'));
if ($kominfo) {
    buatPengurus($kominfo->id, 'Rafi Sidiq Amrullah',   'Menteri');
    buatPengurus($kominfo->id, 'Nazla Nafisal Hakim',   'Biro');
    buatPengurus($kominfo->id, 'Nurul Azmi Oktavannia', 'Biro');
}

// ADKESMA
$adkesma = $kemList->get('ADKESMA') ?? $kemList->first(fn($k) => str_contains(strtolower($k->nama_kementerian), 'adkesma') || str_contains(strtolower($k->nama_kementerian), 'advokasi'));
if ($adkesma) {
    buatPengurus($adkesma->id, 'Zahra W.A.P',    'Menteri');
    buatPengurus($adkesma->id, 'Givan Mardiana', 'Biro');
    buatPengurus($adkesma->id, 'Muhammad Daffa', 'Biro');
    buatPengurus($adkesma->id, 'Viny Isri Fegi M', 'Biro');
}

// KEMENANSTRAT
$anstrat = $kemList->get('KEMENANSTRAT') ?? $kemList->first(fn($k) => str_contains(strtolower($k->nama_kementerian), 'strategis') || str_contains(strtolower($k->nama_kementerian), 'anstrat'));
if ($anstrat) {
    buatPengurus($anstrat->id, 'Rizki Alwi Setiawan', 'Menteri');
    buatPengurus($anstrat->id, 'Ladifa Olwi Salsa',   'Wakil Menteri');
    buatPengurus($anstrat->id, 'Ragil Muhammad',       'Sekretaris Menteri');
}

// KEMENDAGRI
$dagri = $kemList->get('KEMENDAGRI') ?? $kemList->get('DAGRI') ?? $kemList->first(fn($k) => str_contains(strtolower($k->nama_kementerian), 'dalam negeri'));
if ($dagri) {
    buatPengurus($dagri->id, 'Amira Ramadhanty',    'Menteri');
    buatPengurus($dagri->id, 'Andra Ahmad S',        'Biro');
    buatPengurus($dagri->id, 'Sasa Gasby Megantara', 'Biro');
}

echo "\n✓ Selesai. KEMENPSDM bisa ditambah manual via /admin/pengurus\n";
echo "\nKementerian yang terdaftar:\n";
Kementerian::all()->each(fn($k) => print("  [{$k->kode}] {$k->nama_kementerian}\n"));
