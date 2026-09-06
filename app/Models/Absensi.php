<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'pengurus_id',
        'program_kerja_id',
        'tanggal',
        'status_kehadiran',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    const STATUS = [
        'hadir' => 'Hadir',
        'izin'  => 'Izin',
        'alfa'  => 'Alfa',
    ];

    public function getStatusColorAttribute(): string
    {
        return match ($this->status_kehadiran) {
            'hadir' => 'bg-green-50 text-green-700 border border-green-200',
            'izin'  => 'bg-amber-50 text-amber-700 border border-amber-200',
            'alfa'  => 'bg-red-50 text-red-700 border border-red-200',
            default => 'bg-slate-100 text-slate-500',
        };
    }

    public function pengurus()
    {
        return $this->belongsTo(Pengurus::class);
    }

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }
}
