<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trainee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'first_name',
        'last_name',
        'father_name',
        'national_code',
        'phone',
        'birth_date',
        'registration_status',
        'exam_status',
        'certificate_status',
        'total_fee',
        'discount_percent',
        'exam_fee',
        'exam_date',
        'exam_date_shamsi',
        'image',
        'file',
        'note',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'exam_date' => 'date',
        'total_fee' => 'integer',
        'discount_percent' => 'integer',
        'exam_fee' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getDiscountAmountAttribute(): int
    {
        return (int)(($this->total_fee * $this->discount_percent) / 100);
    }

    public function getFinalFeeAttribute(): int
    {
        return (int)($this->total_fee - $this->discount_amount);
    }

    public function getPaidAmountAttribute(): int
    {
        return (int)$this->payments()->sum('amount');
    }

    public function getRemainingAmountAttribute(): int
    {
        return max(0, (int)($this->final_fee - $this->paid_amount));
    }
}
