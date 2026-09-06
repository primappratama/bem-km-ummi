<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DokumenLpj extends Model
{
    protected $table = 'dokumen_lpj';

    protected $fillable = [
        'user_id',
        'program_kerja_id',
        'judul',
        'file_path',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }

    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    public function getFileExtAttribute(): string
    {
        return strtoupper(pathinfo($this->file_path, PATHINFO_EXTENSION));
    }

    public function getFileSizeAttribute(): string
    {
        $bytes = Storage::disk('public')->size($this->file_path);
        if ($bytes >= 1048576) return round($bytes / 1048576, 1) . ' MB';
        return round($bytes / 1024, 1) . ' KB';
    }
}
