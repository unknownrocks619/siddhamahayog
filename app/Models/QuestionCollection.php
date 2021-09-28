<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionCollection extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "sibir_record_id",
        "question_term",
        "question_term_slug",
        "sortable",
        "exam_start_date",
        "exam_end_date",
        "start_time",
        "end_time",
        "objectives",
        "total_exam_time",
        "description",
        "user_login_id"
    ];

    public function sibir() {
        return $this->belongsTo(SibirRecord::class,'sibir_record_id');
    }

    public function questions(){
        return $this->hasMany(Questions::class,'question_collections_id');
    }
}
