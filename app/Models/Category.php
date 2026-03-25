<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'type', 'color'];

    public function articles()         { return $this->hasMany(Article::class); }
    public function learningMaterials(){ return $this->hasMany(LearningMaterial::class); }

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($c) => $c->slug = $c->slug ?? Str::slug($c->name));
    }
}
