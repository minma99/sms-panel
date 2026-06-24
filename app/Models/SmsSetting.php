<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
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
