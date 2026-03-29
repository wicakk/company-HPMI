<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',        // TEXT kolom — disimpan sebagai JSON string, di-cast ke array
        'color',
        'sort_order',
        'is_active',
    ];

    /**
     * Cast 'type' otomatis dari/ke PHP array.
     * Di DB tersimpan sebagai: ["artikel","jurnal"]
     * Di PHP terbaca sebagai: ['artikel', 'jurnal']
     */
    protected $casts = [
        'type'      => 'array',
        'is_active' => 'boolean',
    ];

    // ── Helper: cek apakah kategori ini termasuk tipe tertentu ──
    public function hasType(string $type): bool
    {
        return in_array($type, (array) ($this->type ?? []));
    }

    // ── Scope filter per tipe (untuk query di luar controller) ──
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', 'like', '%"'.$type.'"%');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}