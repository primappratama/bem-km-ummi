<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Profil extends Model
{
    protected $table = 'settings';

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, string $default = ''): string
    {
        $val = static::where('key', $key)->value('value');
        return $val ?? $default;
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get misi as array.
     */
    public static function getMisi(): array
    {
        $raw = static::where('key', 'misi')->value('value');
        if (!$raw) return [];
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
