<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'color', 'type', 'sort_order', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Auto slug dari name
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function articles()  { return $this->hasMany(Article::class); }
    public function journals()  { return $this->hasMany(Journal::class, 'category', 'name'); }
    public function materials() { return $this->hasMany(Material::class); }

    // Label warna untuk badge
    public function getTextColorAttribute(): string
    {
        // Hitung luminance untuk auto text color (hitam/putih)
        $hex = ltrim($this->color, '#');
        [$r, $g, $b] = [hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2))];
        $luminance = (0.299*$r + 0.587*$g + 0.114*$b) / 255;
        return $luminance > 0.5 ? '#1e293b' : '#ffffff';
    }
}