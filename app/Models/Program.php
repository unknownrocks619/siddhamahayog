<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    public function active_batch() {
        return $this->hasOne(ProgramBatch::class,"program_id")->where('active',true)->latest();
    }

    public function batches() {
        return $this->hasMany(ProgramBatch::class,"program_id");
    }

    public function program_videos() {
        return $this->hasMany(ProgramChapterLession::class,"program_id");
    }

    public function courses() {
        return $this->hasMany(ProgramCourseResources::class,"program_id");
    }

    public function active_fees() {
        return $this->hasOne(ProgramCourseFee::class,"program_id")->latest();
    }

    public function student_fee(){
        return $this->hasOne(ProgramStudentFee::class,"program_id");
    }
}
