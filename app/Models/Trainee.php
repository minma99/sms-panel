<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Trainee extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'otp_code',
        'otp_expires_at',
        'otp_verified_at',
        // هر فیلد دیگری که داری
    ];

    protected $hidden = [
        'otp_code',
        'remember_token',
    ];

    protected $casts = [
        'otp_expires_at' => 'datetime',
        'otp_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
