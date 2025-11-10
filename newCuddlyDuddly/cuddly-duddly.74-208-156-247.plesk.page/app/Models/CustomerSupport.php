<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupport extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'admin_id',
        'order_id',
        'subject',
        'message',
        'status',
        'priority',
        'ticket_id',
    ];

    // ✅ Relationships
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function admin()
    {
        return $this->belongsTo(AdminUser::class, 'admin_id');
    }

    public function messages()
    {
        return $this->hasMany(CustomerSupportMessage::class, 'support_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($support) {
            if (empty($support->ticket_id)) {
                $support->ticket_id = 'CUST-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
            }
        });
    }
}
