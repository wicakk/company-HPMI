<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','category_id','title','slug','excerpt',
        'content','thumbnail','status','views','published_at',
    ];
    protected $casts = ['published_at' => 'datetime'];

    public function user()     { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }

    public function scopePublished($q) { return $q->where('status','published')->whereNotNull('published_at'); }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($a) => $a->slug = $a->slug ?? Str::slug($a->title));
    }
}
