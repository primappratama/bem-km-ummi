<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'pengurus';

    protected $fillable = [
        'user_id',
        'kementerian_id',
        'nama',
        'jabatan',
        'kontak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kementerian()
    {
        return $this->belongsTo(Kementerian::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
