<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pengurus;
use App\Models\Kementerian;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        // Helper
        $buat = function (?string $kodeKem, string $nama, string $jabatan, string $role = 'kementerian') {
            $kemId = null;
            if ($kodeKem) {
                $kem = Kementerian::where('kode', $kodeKem)->first();
                $kemId = $kem?->id;
            }

            $email = strtolower(preg_replace('/[^a-z0-9]/i', '.', $nama)) . '@bemkm.ac.id';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $nama,
                    'password' => Hash::make('password'),
                    'role'     => $role,
                ]
            );

            Pengurus::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'kementerian_id' => $kemId,
                    'nama'           => $nama,
                    'jabatan'        => $jabatan,
                ]
            );
        };

        // ─── Pengurus Inti ────────────────────────────────────────────────
        $buat(null, 'Vicran Patinailaya Namadula', 'Presiden BEM', 'super_admin');
        $buat(null, 'Muhamad Balyan', 'Wakil Presiden BEM', 'super_admin');

        // ─── KEMENLU ─────────────────────────────────────────────────────
        $buat('KEMENLU', 'Saddam Syahrul Rifaldi', 'Menteri');
        $buat('KEMENLU', 'Fadhil Ahmad Fauzan', 'Biro');

        // ─── KEMENDIKIL ──────────────────────────────────────────────────
        $buat('KEMENDIKIL', 'Senja Maulana Ispahan', 'Menteri');
        $buat('KEMENDIKIL', 'Syahfirizqi Azmi', 'Biro');

        // ─── KEMENKOMINFO ─────────────────────────────────────────────────
        $buat('KEMENKOMINFO', 'Rafi Sidiq Amrullah', 'Menteri');
        $buat('KEMENKOMINFO', 'Nazla Nafisal Hakim', 'Biro');
        $buat('KEMENKOMINFO', 'Nurul Azmi Oktavannia', 'Biro');

        // ─── ADKESMA ─────────────────────────────────────────────────────
        $buat('ADKESMA', 'Zahra W.A.P', 'Menteri');
        $buat('ADKESMA', 'Givan Mardiana', 'Biro');
        $buat('ADKESMA', 'Muhammad Daffa', 'Biro');
        $buat('ADKESMA', 'Viny Isri Fegi M', 'Biro');

        // ─── KEMENANSTRAT ─────────────────────────────────────────────────
        $buat('KEMENANSTRAT', 'Rizki Alwi Setiawan', 'Menteri');
        $buat('KEMENANSTRAT', 'Ladifa Olwi Salsa', 'Wakil Menteri');
        $buat('KEMENANSTRAT', 'Ragil Muhammad', 'Sekretaris Menteri');

        // ─── KEMENDAGRI ───────────────────────────────────────────────────
        $buat('KEMENDAGRI', 'Amira Ramadhanty', 'Menteri');
        $buat('KEMENDAGRI', 'Andra Ahmad S', 'Biro');
        $buat('KEMENDAGRI', 'Sasa Gasby Megantara', 'Biro');

        $this->command->info('✓ Pengurus seeded (' . Pengurus::count() . ' pengurus)');
        $this->command->info('  KEMENPSDM belum ada data — tambah manual via /admin/pengurus');
    }
}
