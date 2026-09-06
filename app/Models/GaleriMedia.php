<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriMedia extends Model
{
    use HasFactory;

    protected $table = 'galeri_media';

    protected $fillable = [
        'galeri_id',
        'file_path',
        'tipe',
    ];

    public function galeri()
    {
        return $this->belongsTo(Galeri::class);
    }
}
