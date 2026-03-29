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

    // ── Simpan value & hapus cache (DIGABUNG — hanya satu) ───────
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}");
        Cache::forget('settings_all');
    }

    // ── Ambil URL publik gambar dari path relatif di DB ───────────
    public static function imageUrl(string $key, ?string $fallback = null): ?string
    {
        $path = static::get($key);

        if (!$path) return $fallback;

        if (str_starts_with($path, 'http')) return $path;

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        return $fallback;
    }

    // ── Ambil semua setting sebagai array key => value ────────────
    public static function all_map(): array
    {
        return Cache::remember('settings_all', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    // ── Ambil slide banner yang aktif ─────────────────────────────
    public static function activeSlides(): array
    {
        $slides = [];
        for ($i = 1; $i <= 5; $i++) {
            if (static::get("banner_slide_{$i}_active", '0') !== '1') continue;

            $path     = static::get("banner_slide_{$i}_image", '');
            $slides[] = [
                'image_url' => $path && Storage::disk('public')->exists($path)
                                ? Storage::url($path) : null,
                'title'    => static::get("banner_slide_{$i}_title", ''),
                'subtitle' => static::get("banner_slide_{$i}_subtitle", ''),
                'link'     => static::get("banner_slide_{$i}_link", ''),
                'color'    => static::get("banner_slide_{$i}_color", '#1a4e8a'),
            ];
        }
        return $slides;
    }

    // ── Ambil data bank yang aktif ────────────────────────────────
    public static function activeBanks(): array
    {
        $banks = [];
        for ($i = 1; $i <= 5; $i++) {
            if (static::get("bank_{$i}_active", '0') !== '1') continue;

            $name   = static::get("bank_{$i}_name", '');
            $number = static::get("bank_{$i}_number", '');
            if (!$name && !$number) continue;

            $banks[] = [
                'name'   => $name,
                'number' => $number,
                'owner'  => static::get("bank_{$i}_owner", ''),
            ];
        }
        return $banks;
    }

    // ── Hapus semua cache settings ────────────────────────────────
    public static function clearAllCache(): void
    {
        Cache::forget('settings_all');
        foreach (static::pluck('key') as $key) {
            Cache::forget("setting_{$key}");
        }
    }
}