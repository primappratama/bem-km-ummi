<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_lpj', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('program_kerja_id')->nullable();
            $table->string('judul');
            $table->string('file_path');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('program_kerja_id')
                  ->references('id')->on('program_kerja')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_lpj');
    }
};
