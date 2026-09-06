<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengurus_id')->constrained('pengurus')->cascadeOnDelete();
            $table->foreignId('program_kerja_id')->constrained('program_kerja')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('status_kehadiran', ['hadir', 'izin', 'alfa'])->default('hadir');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
