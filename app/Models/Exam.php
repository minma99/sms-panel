<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'trainee_id',
        'exam_title',
        'exam_date',
        'start_time',
        'end_time',
        'exam_type',
        'location',
        'status',
        'note',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}
