<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings'; // nama tabel eksplisit

    protected $fillable = ['key', 'value', 'type', 'label'];

    // ============================================================
    // Static helper: ambil setting dengan 1 baris kode
    // Contoh: SiteSetting::get('class_name') => 'TIF A 2022'
    //
    // Pakai Cache supaya tidak query DB setiap kali halaman dimuat.
    // Cache akan expire 1 jam, atau di-clear saat admin update setting.
    // ============================================================
    public static function getValue(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function setValue(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}"); // hapus cache lama
    }
}