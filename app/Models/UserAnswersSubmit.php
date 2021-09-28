<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswersSubmit extends Model
{
    use HasFactory;

    public function question() {
        return $this->belongsTo(Questions::class,"question_id");
    }

    public function answer_collection()
    {
        return $this->belongsTo(UserAnswer::class,'user_answer_id');
    }
}
