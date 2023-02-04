<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramExamQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'question_detail' => 'object',
        'category' => 'object'
    ];

    public function questionModel()
    {
        return $this->belongsTo(ProgramExam::class, 'program_exam_id');
    }
}
