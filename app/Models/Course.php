<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'price',
        'duration',
        'capacity',
        'start_date',
        'end_date',
        'start_date_shamsi',
        'end_date_shamsi',
        'description',
    ];

    public function trainees(): HasMany
    {
        return $this->hasMany(Trainee::class);
    }
}
