<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirasi extends Model
{
    protected $table = 'aspirasi';

    protected $fillable = [
        'nama',
        'fakultas',
        'isi_aspirasi',
        'tanggal',
        'status_tindak_lanjut',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    const STATUS = [
        'belum_ditindaklanjuti' => 'Belum Ditindaklanjuti',
        'diproses'              => 'Diproses',
        'selesai'               => 'Selesai',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS[$this->status_tindak_lanjut] ?? $this->status_tindak_lanjut;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status_tindak_lanjut) {
            'belum_ditindaklanjuti' => 'bg-amber-50 text-amber-700 border border-amber-200',
            'diproses'              => 'bg-blue-50 text-blue-700 border border-blue-200',
            'selesai'               => 'bg-green-50 text-green-700 border border-green-200',
            default                 => 'bg-slate-100 text-slate-500',
        };
    }
}
