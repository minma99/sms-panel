<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'trainee_id',
        'amount',
        'remaining_after_payment',
        'payment_type',
        'payment_method',
        'tracking_code',
        'payment_date',
        'payment_date_shamsi',
        'note'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'integer'
    ];

    public function trainee(): BelongsTo
    {
        return $this->belongsTo(Trainee::class);
    }

    public function getAmountFormattedAttribute(): string
    {
        return number_format($this->amount);
    }
}
