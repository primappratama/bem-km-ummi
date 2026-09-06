<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $table = 'program_kerja';

    protected $fillable = [
        'kementerian_id',
        'nama_kegiatan',
        'tanggal_pelaksanaan',
        'anggaran',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pelaksanaan' => 'date',
            'anggaran'            => 'decimal:2',
        ];
    }

    // ─── Relasi ───────────────────────────────────────────────────────────────

    public function kementerian()
    {
        return $this->belongsTo(Kementerian::class);
    }

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /** Warna badge status untuk UI */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'rencana'  => 'bg-slate-100 text-slate-500',
            'berjalan' => 'bg-orange/10 text-orange',
            'selesai'  => 'bg-green-50 text-green-600',
            default    => 'bg-slate-100 text-slate-400',
        };
    }

    /** Label status yang lebih ramah */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'rencana'  => 'Rencana',
            'berjalan' => 'Berjalan',
            'selesai'  => 'Selesai',
            default    => $this->status,
        };
    }
}
