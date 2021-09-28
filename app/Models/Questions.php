<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questions extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "question_collections_id",
        "user_login_id",
        "question_type",
        "sibir_record_id",
        "class_id",
        "course_id",
        "question_title",
        "total_point",
        "objectives",
        "correct_number",
        "question_structure",
        'alternate_question_title'
    ];

    public function question_collections() {
        return $this->belongsTo(QuestionCollection::class,"question_collections_id");
    }

    public function sibir(){
        return $this->belongsTo(SibirRecord::class,'sibir_record_id');
    }

    public function total_submit (){
        return $this->hasMany(UserAnswersSubmit::class,"question_id");
    }

    public function correct_answer() {

    }

    public function wrong_answer() {
        return $this->hasMany(UserAnswersSubmit::class,'question_id')
                ->where('is_correct',false);
    }

    public function right_answer(){
        return $this->hasMany(UserAnswersSubmit::class,'question_id')
                        ->where('is_correct',true);

    }
}
