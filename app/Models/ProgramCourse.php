<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramCourse extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * List all video related to selected course id.
     */
    public function lession()
    {
        return $this->hasMany(ProgramChapterLession::class, "program_course_id");
    }

    /**
     * List all resource (except video) to selected course id.
     */
    public function resources()
    {
        return $this->hasMany(ProgramCourseResources::class, "program_course_id");
    }

    public function videoWatchHistory()
    {
        return $this->hasMany(LessionWatchHistory::class, "program_course_id");
    }
}
