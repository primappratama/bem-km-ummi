<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kementerian;
use App\Models\ProgramKerja;

class ProgramKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $proker = [
            // KEMENLU
            ['kode' => 'KEMENLU',      'nama' => 'Diplomasi Kampus dan Relasi',                        'tanggal' => '2026-03-15', 'status' => 'selesai'],
            ['kode' => 'KEMENLU',      'nama' => 'Studi Banding',                                       'tanggal' => '2026-05-20', 'status' => 'selesai'],

            // KEMENDIKIL
            ['kode' => 'KEMENDIKIL',   'nama' => 'Sekolah Kastrat dan Eksekutif (SEKATIF)',             'tanggal' => '2026-04-10', 'status' => 'selesai'],

            // KEMENKOMINFO
            ['kode' => 'KEMENKOMINFO', 'nama' => 'AKTIF — Aktivasi Informasi Media Sosial BEM KM UMMI', 'tanggal' => '2026-02-01', 'status' => 'berjalan'],
            ['kode' => 'KEMENKOMINFO', 'nama' => 'Podcast BEM KM UMMI',                                 'tanggal' => '2026-03-01', 'status' => 'berjalan'],
            ['kode' => 'KEMENKOMINFO', 'nama' => 'Website Resmi BEM KM UMMI',                           'tanggal' => '2026-06-01', 'status' => 'selesai'],

            // ADKESMA
            ['kode' => 'ADKESMA',      'nama' => 'Klinik Aspirasi dan Forum Dengar Pendapat (KAFDP)',   'tanggal' => '2026-03-20', 'status' => 'selesai'],
            ['kode' => 'ADKESMA',      'nama' => 'Bantuan, Beasiswa, dan Kesejahteraan Mahasiswa (BBKM)','tanggal' => '2026-04-05', 'status' => 'selesai'],
            ['kode' => 'ADKESMA',      'nama' => 'Survei Kesejahteraan, Monitoring & Evaluasi (SKM-Monev)','tanggal' => '2026-05-01', 'status' => 'berjalan'],

            // KEMENANSTRAT
            ['kode' => 'KEMENANSTRAT', 'nama' => 'REVOLUZINE — Publikasi Isu Strategis',               'tanggal' => '2026-02-15', 'status' => 'berjalan'],
            ['kode' => 'KEMENANSTRAT', 'nama' => 'ANDRI — Analisis Dalam Negeri',                      'tanggal' => '2026-03-10', 'status' => 'berjalan'],
            ['kode' => 'KEMENANSTRAT', 'nama' => 'Kilas Balik BEM KM UMMI 2025',                       'tanggal' => '2026-02-01', 'status' => 'selesai'],
            ['kode' => 'KEMENANSTRAT', 'nama' => 'RISOL — Riset dan Analisis Isu Lokal',               'tanggal' => '2026-04-01', 'status' => 'berjalan'],
            ['kode' => 'KEMENANSTRAT', 'nama' => 'Diskusi Publik',                                      'tanggal' => '2026-05-15', 'status' => 'selesai'],

            // KEMENPSDM
            ['kode' => 'KEMENPSDM',    'nama' => 'Upgrading dan Internalisasi BEM',                     'tanggal' => '2026-02-10', 'status' => 'selesai'],
            ['kode' => 'KEMENPSDM',    'nama' => 'Monitoring dan Penyelarasan Ormawa (MONEV)',          'tanggal' => '2026-04-20', 'status' => 'berjalan'],
            ['kode' => 'KEMENPSDM',    'nama' => 'Gelora Rakyat',                                       'tanggal' => '2026-05-25', 'status' => 'rencana'],

            // KEMENDAGRI
            ['kode' => 'KEMENDAGRI',   'nama' => 'Pembentukan Konstitusi (Campus Decode)',              'tanggal' => '2026-03-01', 'status' => 'selesai'],
            ['kode' => 'KEMENDAGRI',   'nama' => 'Sosialisasi Konstitusi',                              'tanggal' => '2026-04-15', 'status' => 'selesai'],
        ];

        foreach ($proker as $p) {
            $kem = Kementerian::where('kode', $p['kode'])->first();
            if (!$kem) continue;

            ProgramKerja::firstOrCreate(
                [
                    'kementerian_id' => $kem->id,
                    'nama_kegiatan'  => $p['nama'],
                ],
                [
                    'tanggal_pelaksanaan' => $p['tanggal'],
                    'anggaran'            => 0,
                    'status'              => $p['status'],
                ]
            );
        }

        $this->command->info('✓ Program Kerja seeded (' . ProgramKerja::count() . ' program kerja)');
    }
}
