<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseChapter extends Model
{
    use HasFactory;
    

    public function sibir_record() {
        return $this->belongsTo(SibirRecord::class,'sibir_record_id');
    }

    public function videos() {
        return $this->hasMany(OfflineVideo::class,'course_chapter_id');
    }
}
