<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'konten',
        'thumbnail',
        'status',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
