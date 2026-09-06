<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default values
        DB::table('settings')->insert([
            ['key' => 'visi',         'value' => 'Mewujudkan BEM KM UMMI sebagai garda gerakan mahasiswa yang kritis, progresif, dan kolaboratif.', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'misi',         'value' => json_encode([
                'Mengadvokasi dan memperjuangkan hak serta kesejahteraan mahasiswa.',
                'Membangun sistem komunikasi dan informasi yang transparan dan akuntabel.',
                'Mengembangkan kapasitas mahasiswa melalui program pemberdayaan SDM.',
                'Memperkuat diplomasi internal dan eksternal kampus.',
                'Menciptakan ruang akademik yang kritis dan produktif.',
                'Mengelola keuangan organisasi secara transparan dan bertanggung jawab.',
                'Membangun sistem tata kelola organisasi yang adaptif dan berkelanjutan.',
            ]), 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'deskripsi',    'value' => 'Menghidupkan tradisi intelektual, advokasi, dan gerakan mahasiswa yang kritis, kolaboratif, dan progresif di Universitas Muhammadiyah Sukabumi.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
