<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobile',
        'message',
        'type',
        'status',
        'provider',
        'template_key',
        'provider_message_id',
        'response',
        'error_message',
        'user_id',
        'related_type',
        'related_id',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function related()
    {
        return $this->morphTo();
    }
}
