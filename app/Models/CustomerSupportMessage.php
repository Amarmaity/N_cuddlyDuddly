<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_id',
        'sender_id',
        'sender_type',
        'message',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    // ✅ Relationships
    public function support()
    {
        return $this->belongsTo(CustomerSupport::class, 'support_id');
    }

    public function sender()
    {
        return $this->morphTo(null, 'sender_type', 'sender_id');
    }
}
