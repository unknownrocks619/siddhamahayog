<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    public function answers() {
        return $this->hasMany(UserAnswersSubmit::class,'user_answer_id');
    }

    public function objective_answer(){
        return $this->hasMany(UserAnswersSubmit::class,"user_answer_id")
                            ->where('question_type','objective');
    }

    public function subjective_answer(){
        return $this->hasMany(UserAnswersSubmit::class,'user_answer_id')->where('question_type','subjective');
    }
}
