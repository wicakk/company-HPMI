<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','title','slug','description','thumbnail','location',
        'meeting_url','start_date','end_date','price','is_member_only',
        'is_free','quota','status',
    ];
    protected $casts = [
        'start_date'     => 'datetime',
        'end_date'       => 'datetime',
        'is_member_only' => 'boolean',
        'is_free'        => 'boolean',
        'price'          => 'decimal:2',
    ];

    public function user()          { return $this->belongsTo(User::class); }
    public function registrations() { return $this->hasMany(EventRegistration::class); }

    public function scopeOpen($q)      { return $q->where('status','open'); }
    public function isQuotaFull(): bool{ return $this->quota && $this->registrations()->count() >= $this->quota; }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($e) => $e->slug = $e->slug ?? Str::slug($e->title));
    }
}
