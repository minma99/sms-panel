<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'sms_enabled',
        'auto_sms_enabled',
        'test_mode',
        'provider',
        'api_key',
        'sender_number',
        'base_url',
    ];
}
