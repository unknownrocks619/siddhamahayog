<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramChapterLession extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'program_course_id',
        'program_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'video_link',
        
    ];

    protected $alias = [
        'lession_name' => 'name'
    ];

    public function course()
    {
        return $this->belongsTo(ProgramCourse::class, "program_course_id");
    }
}
