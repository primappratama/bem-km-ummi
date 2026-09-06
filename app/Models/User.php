<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Role Helpers ──────────────────────────────────────────────────────────

    /** Cek apakah user memiliki salah satu dari role yang diberikan. */
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isSekretaris(): bool
    {
        return $this->role === 'sekretaris';
    }

    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }

    public function isKementerian(): bool
    {
        return $this->role === 'kementerian';
    }

    /** Label ramah untuk ditampilkan di UI. */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'super_admin'  => 'Presiden / Admin',
            'sekretaris'   => 'Sekretaris Umum',
            'bendahara'    => 'Bendahara Umum',
            'kementerian'  => 'Pengurus Kementerian',
            default        => 'Pengguna',
        };
    }

    /** Warna badge role untuk UI. */
    public function getRoleColorAttribute(): string
    {
        return match ($this->role) {
            'super_admin'  => 'bg-red/10 text-red',
            'sekretaris'   => 'bg-navy/10 text-navy',
            'bendahara'    => 'bg-orange/10 text-orange',
            'kementerian'  => 'bg-slate-100 text-slate-600',
            default        => 'bg-slate-100 text-slate-500',
        };
    }

    // ─── Relations (akan dipakai modul berikutnya) ─────────────────────────────

    public function pengurus()
    {
        return $this->hasOne(\App\Models\Pengurus::class);
    }
}
