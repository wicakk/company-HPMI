<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','member_code','phone','address','institution',
        'specialty','status','joined_at','expired_at',
    ];
    protected $casts = ['joined_at' => 'date', 'expired_at' => 'date'];

    public function user()     { return $this->belongsTo(User::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function isFree(): bool           { return $this->status === 'free'; }
    public function isPremiumPending(): bool  { return $this->status === 'premium_pending'; }
    public function isPremium(): bool         { return $this->status === 'premium'; }
    public function isExpired(): bool         { return $this->status === 'expired' || ($this->expired_at && $this->expired_at->isPast()); }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            if (empty($m->member_code)) {
                $m->member_code = 'HPMI-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }
}
