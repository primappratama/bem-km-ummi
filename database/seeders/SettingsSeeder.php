<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profil;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'visi'      => 'Mewujudkan BEM KM UMMI sebagai garda gerakan mahasiswa yang kritis, progresif, dan kolaboratif.',
            'deskripsi' => 'Menghidupkan tradisi intelektual, advokasi, dan gerakan mahasiswa yang kritis, kolaboratif, dan progresif di Universitas Muhammadiyah Sukabumi.',
            'misi'      => json_encode([
                'Mengadvokasi dan memperjuangkan hak serta kesejahteraan mahasiswa.',
                'Membangun sistem komunikasi dan informasi yang transparan dan akuntabel.',
                'Mengembangkan kapasitas mahasiswa melalui program pemberdayaan SDM.',
                'Memperkuat diplomasi internal dan eksternal kampus.',
                'Menciptakan ruang akademik yang kritis dan produktif.',
                'Mengelola keuangan organisasi secara transparan dan bertanggung jawab.',
                'Membangun sistem tata kelola organisasi yang adaptif dan berkelanjutan.',
            ]),
        ];

        foreach ($settings as $key => $value) {
            Profil::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->command->info('✓ Settings seeded (visi, misi, deskripsi)');
    }
}
