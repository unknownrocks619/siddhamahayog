<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberQuestionAnswerDetail extends Model
{
    use HasFactory;

    protected $table = 'member_question_answers_detail';

    protected $casts = [
        'result' => 'object',
        'exam_detail' => 'array',
        'question_detail' => 'array'
    ];
}
