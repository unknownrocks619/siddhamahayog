<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramChapterLession extends Model
{
    use HasFactory, SoftDeletes;

    public function course(){
        return $this->belongsTo(ProgramCourse::class,"program_course_id");
    }
}
