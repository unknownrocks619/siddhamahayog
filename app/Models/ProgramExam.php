<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramExam extends Model
{
    use HasFactory, SoftDeletes;

    public function questions()
    {
        return $this->hasMany(ProgramExamQuestion::class, 'program_exam_id');
    }
}
