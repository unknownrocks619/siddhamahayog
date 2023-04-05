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


    public function attempts()
    {
        return $this->hasMany(MemberQuestionAnswerDetail::class, 'program_exam_id')
            ->where('member_id', auth()->id())
            ->where('status', 'completed');
    }

    public function all_attempts()
    {
        return $this->hasMany(MemberQuestionAnswerDetail::class, 'program_exam_id')
            ->where('status', 'completed');
    }
}
