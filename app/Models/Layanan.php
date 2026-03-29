<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use SoftDeletes;

    protected $table = 'layanans';

    protected $fillable = [
        'nama',
        'slug',
        'ikon',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'kategori',
        'urutan',
        'status',
        'gambar',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    // ── Boot: auto-generate slug ──────────────────────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }

    public function scopeKategori($query, string $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'aktif' ? 'Aktif' : 'Nonaktif';
    }

    public function getGambarUrlAttribute(): ?string
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }

    public function getIsAktifAttribute(): bool
    {
        return $this->status === 'aktif';
    }
}
