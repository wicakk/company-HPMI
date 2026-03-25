<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['email_verified_at' => 'datetime'];

    public function isAdmin(): bool        { return $this->role === 'admin'; }
    public function isMember(): bool       { return in_array($this->role, ['member', 'premium']); }
    public function isPremium(): bool      { return $this->role === 'premium'; }
    public function isPremiumPending(): bool { return $this->member?->status === 'premium_pending'; }

    public function member()             { return $this->hasOne(Member::class); }
    public function articles()           { return $this->hasMany(Article::class); }
    public function events()             { return $this->hasMany(Event::class); }
    public function eventRegistrations() { return $this->hasMany(EventRegistration::class); }
    public function learningMaterials()  { return $this->hasMany(LearningMaterial::class); }
    public function announcements()      { return $this->hasMany(Announcement::class); }
}
