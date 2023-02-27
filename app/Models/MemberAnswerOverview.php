<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberAnswerOverview extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'member_id',
        'question_collection_id',
        'attempted_questions',
        'total_marks_obtained',
        'total_wrong_answer',
        'total_right_answer',
        'markings',
        'revisions'
    ];

    protected $casts = [
        'attempted_questions' => 'object'
    ];
}
