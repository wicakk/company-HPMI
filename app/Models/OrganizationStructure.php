<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationStructure extends Model
{
    protected $fillable = ['name','position','photo','bio','period','order_index','is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function scopeActive($q)  { return $q->where('is_active', true); }
    public function scopeOrdered($q) { return $q->orderBy('order_index'); }
}
