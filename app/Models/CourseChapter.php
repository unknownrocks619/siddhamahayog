<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseChapter extends Model
{
    use HasFactory, SoftDeletes;
    

    public function sibir_record() {
        return $this->belongsTo(SibirRecord::class,'sibir_record_id');
    }

    public function videos() {
        return $this->hasMany(OfflineVideo::class,'course_chapter_id');
    }
}
