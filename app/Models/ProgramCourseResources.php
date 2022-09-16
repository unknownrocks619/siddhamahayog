<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramCourseResources extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "resource" => "object"
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    public function program_course()
    {
        return $this->belongsTo(ProgramCourse::class, "program_course_id");
    }
}
