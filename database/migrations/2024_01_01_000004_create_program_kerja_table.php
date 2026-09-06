<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kementerian_id')->constrained('kementerian')->cascadeOnDelete();
            $table->string('nama_kegiatan', 150);
            $table->date('tanggal_pelaksanaan');
            $table->decimal('anggaran', 12, 2)->default(0);
            $table->enum('status', ['rencana', 'berjalan', 'selesai'])->default('rencana');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_kerja');
    }
};
