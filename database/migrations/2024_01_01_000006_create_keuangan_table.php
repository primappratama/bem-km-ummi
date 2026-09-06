<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('program_kerja_id')->nullable()->constrained('program_kerja')->nullOnDelete();
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->decimal('jumlah', 12, 2);
            $table->string('keterangan')->nullable();
            $table->date('tanggal_transaksi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
