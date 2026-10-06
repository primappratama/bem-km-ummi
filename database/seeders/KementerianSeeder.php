<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KementerianSeeder extends Seeder
{
    public function run(): void
    {
        $kementerian = [
            [
                'kode'             => 'KEMENLU',
                'nama_kementerian' => 'Kementerian Luar Negeri',
                'deskripsi'        => 'Meningkatkan eksistensi BEM dan memperluas jaringan kerja sama eksternal melalui diplomasi kampus, relasi dengan BEM/organisasi lain, dan studi banding.',
            ],
            [
                'kode'             => 'KEMENDIKIL',
                'nama_kementerian' => 'Kementerian Pendidikan & Keilmuan',
                'deskripsi'        => 'Mewujudkan ruang pendidikan kampus yang kritis, progresif, dan kolaboratif dalam mengembangkan keilmuan mahasiswa sebagai fondasi gerakan intelektual dan sosial.',
            ],
            [
                'kode'             => 'KEMENKOMINFO',
                'nama_kementerian' => 'Kementerian Komunikasi dan Informasi',
                'deskripsi'        => 'Mewujudkan sistem komunikasi dan informasi BEM KM UMMI yang aktif, kreatif, serta ideologis melalui media sosial, podcast, dan website resmi.',
            ],
            [
                'kode'             => 'ADKESMA',
                'nama_kementerian' => 'Advokasi dan Kesejahteraan Mahasiswa',
                'deskripsi'        => 'Menjadi garda terdepan dalam memperjuangkan hak, aspirasi, dan kesejahteraan mahasiswa yang berkeadilan, responsif, solutif, humanis, dan berintegritas tinggi.',
            ],
            [
                'kode'             => 'KEMENANSTRAT',
                'nama_kementerian' => 'Kementerian Analisis Isu Strategis',
                'deskripsi'        => 'Menjadi pioner yang solutif, progresif, dan kreatif dalam pemenuhan kebutuhan analisis isu yang terstruktur, tersistematis, dan terpercaya.',
            ],
            [
                'kode'             => 'KEMENPSDM',
                'nama_kementerian' => 'Kementerian Pemberdayaan Sumber Daya Manusia',
                'deskripsi'        => 'Memperkuat kapasitas, solidaritas, dan internalisasi nilai-nilai organisasi bagi seluruh pengurus BEM KM UMMI.',
            ],
            [
                'kode'             => 'KEMENDAGRI',
                'nama_kementerian' => 'Kementerian Dalam Negeri',
                'deskripsi'        => 'Menjaga dinamika internal BEM, memperkuat sinergi antarpengurus dan ormawa, serta menata konstitusi dan tata kelola organisasi.',
            ],
        ];

        foreach ($kementerian as $k) {
            \App\Models\Kementerian::firstOrCreate(
                ['kode' => $k['kode']],
                [
                    'nama_kementerian' => $k['nama_kementerian'],
                    'deskripsi'        => $k['deskripsi'],
                ]
            );
        }

        $this->command->info('✓ Kementerian seeded (' . count($kementerian) . ' kementerian)');
    }
}
