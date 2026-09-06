<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kementerian extends Model
{
    protected $table = 'kementerian';

    protected $fillable = [
        'kode',
        'nama_kementerian',
        'deskripsi',
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }

    public function programKerja()
    {
        return $this->hasMany(ProgramKerja::class);
    }
}
