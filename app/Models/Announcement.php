<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'user_id','title','content','type','is_pinned',
        'is_member_only','published_at','expired_at',
    ];
    protected $casts = [
        'is_pinned'      => 'boolean',
        'is_member_only' => 'boolean',
        'published_at'   => 'datetime',
        'expired_at'     => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function scopeActive($q) {
        return $q->whereNotNull('published_at')
                 ->where(fn($q2) => $q2->whereNull('expired_at')->orWhere('expired_at','>',now()));
    }
}
