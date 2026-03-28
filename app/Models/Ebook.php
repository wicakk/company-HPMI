<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ebook extends Model
{
    protected $fillable = [
        'title','author','slug','description','category',
        'cover_path','file_path','file_size','pages',
        'year','access','is_published','download_count'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'download_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($e) => $e->slug = Str::slug($e->title).'-'.uniqid());
    }

    public function isFree(): bool    { return $this->access === 'free'; }
    public function isPremium(): bool { return $this->access === 'premium'; }

    public function canDownload($user = null): bool
    {
        if ($this->isFree()) return true;
        return $user && $user->isPremium();
    }
}