<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'member_id','invoice_no','amount','type','status',
        'va_number','payment_method','paid_at','expired_at','notes',
    ];
    protected $casts = ['paid_at' => 'datetime', 'expired_at' => 'datetime', 'amount' => 'decimal:2'];

    public function member() { return $this->belongsTo(Member::class); }

    public function isPaid(): bool    { return $this->status === 'paid'; }
    public function isPending(): bool { return $this->status === 'pending'; }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($p) {
            if (empty($p->invoice_no)) {
                $p->invoice_no = 'INV-' . date('YmdHis') . '-' . rand(100, 999);
            }
        });
    }
}
