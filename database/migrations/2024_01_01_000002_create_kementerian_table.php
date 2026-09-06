<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kementerian', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique(); // contoh: KEMENLU, KEMENDIKIL, ADKESMA
            $table->string('nama_kementerian', 150);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kementerian');
    }
};
