<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->nullable();
            $table->string('fakultas', 100)->nullable();
            $table->text('isi_aspirasi');
            $table->date('tanggal');
            $table->enum('status_tindak_lanjut', ['belum_ditindaklanjuti', 'diproses', 'selesai'])
                  ->default('belum_ditindaklanjuti');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};
