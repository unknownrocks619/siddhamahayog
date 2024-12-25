<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberUnderLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'student_id',
        'teacher_training_id'
    ];

    public function trainingMeta()
    {
        return $this->belongsTo(UserTrainingCourse::class, 'teacher_training_id');
    }
}
