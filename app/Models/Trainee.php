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
}
