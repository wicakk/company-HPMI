<?php
// app/Models/SiteSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $table    = 'site_settings';
    protected $fillable = ['key', 'value', 'group', 'type'];

    // ── Ambil value (dengan cache 1 jam) ─────────────────────────
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $row = static::where('key', $key)->first();
            return $row ? $row->value : $default;
        });
    }

    // ── Simpan value & hapus cache ────────────────────────────────
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}");
    }

    // ── Ambil URL publik gambar dari path relatif di DB ───────────
    // DB menyimpan: "banners/abc.jpg"
    // Method ini mengembalikan: "http://domain/storage/banners/abc.jpg"
    public static function imageUrl(string $key, ?string $fallback = null): ?string
    {
        $path = static::get($key);

        if (!$path) return $fallback;

        // Sudah full URL — kembalikan langsung
        if (str_starts_with($path, 'http')) return $path;

        // Path relatif — cek apakah file ada lalu buat URL
        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path); // → "/storage/banners/abc.jpg"
        }

        return $fallback;
    }

    // ── Hapus semua cache settings ────────────────────────────────
    public static function clearAllCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting_{$key}");
        }
    }
}
