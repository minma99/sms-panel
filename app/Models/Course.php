<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Morilog\Jalali\Jalalian;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'duration',
        'capacity',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function trainees(): HasMany
    {
        return $this->hasMany(Trainee::class);
    }

    public function getStartDateShamsiAttribute()
    {
        if (!$this->start_date) return null;

        return Jalalian::fromDateTime($this->start_date)->format('Y/m/d');
    }

    public function getEndDateShamsiAttribute()
    {
        if (!$this->end_date) return null;

        return Jalalian::fromDateTime($this->end_date)->format('Y/m/d');
    }
}
