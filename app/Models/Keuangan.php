<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'user_id',
        'program_kerja_id',
        'jenis',
        'jumlah',
        'keterangan',
        'tanggal_transaksi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_transaksi' => 'date',
            'jumlah'            => 'decimal:2',
        ];
    }

    public function getJenisColorAttribute(): string
    {
        return match ($this->jenis) {
            'masuk'  => 'bg-green-50 text-green-600',
            'keluar' => 'bg-red-50 text-red-600',
            default  => 'bg-slate-100 text-slate-500',
        };
    }

    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'masuk'  => 'Masuk',
            'keluar' => 'Keluar',
            default  => $this->jenis,
        };
    }

    public function getJenisPrefixAttribute(): string
    {
        return $this->jenis === 'masuk' ? '+' : '-';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programKerja()
    {
        return $this->belongsTo(ProgramKerja::class);
    }
}