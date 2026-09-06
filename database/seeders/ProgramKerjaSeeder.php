<?php

namespace Database\Seeders;

use App\Models\Kementerian;
use App\Models\ProgramKerja;
use Illuminate\Database\Seeder;

class ProgramKerjaSeeder extends Seeder
{
    /**
     * Data diambil langsung dari PPT resmi Kabinet Revolusioner
     * (PPT_KABINET_20251123_144736_0000.pdf), bukan rekaan.
     * Tanggal pelaksanaan & anggaran belum tercantum di PPT, jadi diisi
     * nilai placeholder (0 / akhir periode) -- silakan sesuaikan manual.
     */
    public function run(): void
    {
        $programs = [
            'KEMENLU' => [
                'Diplomasi Kampus dan Relasi',
                'Studi Banding',
            ],
            'KEMENDIKIL' => [
                'Sekolah Kastrat dan Eksekutif (SEKATIF)',
            ],
            'KEMENKOMINFO' => [
                'AKTIF (Aktivasi Informasi Media Sosial BEM KM UMMI)',
                'Podcast',
                'Pembuatan Website Resmi BEM KM UMMI',
            ],
            'ADKESMA' => [
                'Klinik Aspirasi dan Forum Dengar Pendapat (KAFDP)',
                'Bantuan, Beasiswa, dan Kesejahteraan Mahasiswa (BBKM)',
                'Survei Kesejahteraan, Monitoring & Evaluasi Kebijakan Mahasiswa (SKM-Monev)',
            ],
            'KEMENANSTRAT' => [
                'REVOLUZINE',
                'ANDRI (Analisis Dalam Negeri)',
                'Kilas Balik BEM KM UMMI 2025',
                'RISOL (Riset/Analisis Isu Lokal)',
                'Diskusi Publik',
            ],
            'KEMENPSDM' => [
                'Upgrading dan Internalisasi BEM',
                'MONEV (Monitoring dan Penyelarasan Ormawa)',
                'Gelora Rakyat (GR)',
            ],
            'KEMENDAGRI' => [
                'Pembentukan Konstitusi (Campus Decode)',
                'Sosialisasi Konstitusi',
            ],
        ];

        foreach ($programs as $kode => $list) {
            $kementerian = Kementerian::where('kode', $kode)->first();
            if (! $kementerian) {
                continue;
            }

            foreach ($list as $nama) {
                ProgramKerja::updateOrCreate(
                    [
                        'kementerian_id' => $kementerian->id,
                        'nama_kegiatan' => $nama,
                    ],
                    [
                        'tanggal_pelaksanaan' => now()->addMonths(2)->toDateString(),
                        'anggaran' => 0,
                        'status' => 'rencana',
                    ]
                );
            }
        }
    }
}
