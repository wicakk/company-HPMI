<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'abstract',
        'category',
        'volume',
        'year',
        'download_count',
        'is_published',
        'uploaded_by',
    ];

    protected $casts = [
        'is_published'   => 'boolean',
        'download_count' => 'integer',
        'year'           => 'integer',
    ];

    // ─── Relationships ─────────────────────────────────────────

    /**
     * User yang mengupload jurnal.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ─── Accessors ─────────────────────────────────────────────

    /**
     * URL publik file jurnal.
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    /**
     * Icon class berdasarkan tipe file.
     */
    public function getFileIconAttribute(): string
    {
        return match (strtolower($this->file_type ?? '')) {
            'pdf'                       => 'pdf',
            'doc', 'docx'               => 'word',
            'xls', 'xlsx'               => 'excel',
            'ppt', 'pptx'               => 'powerpoint',
            default                     => 'generic',
        };
    }

    // ─── Scopes ────────────────────────────────────────────────

    /**
     * Hanya jurnal yang dipublikasikan.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Filter berdasarkan kata kunci.
     */
    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) return $query;
        return $query->where(function ($q) use ($keyword) {
            $q->where('title',    'like', "%{$keyword}%")
              ->orWhere('author', 'like', "%{$keyword}%")
              ->orWhere('category', 'like', "%{$keyword}%")
              ->orWhere('abstract', 'like', "%{$keyword}%");
        });
    }

    /**
     * Filter berdasarkan kategori.
     */
    public function scopeByCategory($query, ?string $category)
    {
        if (!$category) return $query;
        return $query->where('category', $category);
    }

    // ─── Helpers ───────────────────────────────────────────────

    /**
     * Tambah counter download.
     */
    public function incrementDownload(): void
    {
        $this->increment('download_count');
    }

    /**
     * Hapus file dari storage sebelum model dihapus.
     */
    protected static function booted(): void
    {
        static::deleting(function (Journal $journal) {
            if ($journal->file_path && Storage::disk('public')->exists($journal->file_path)) {
                Storage::disk('public')->delete($journal->file_path);
            }
        });
    }
}
