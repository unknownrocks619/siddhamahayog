<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfflineVideo extends Model
{
    use HasFactory, SoftDeletes;

    public function event_source() {
        return $this->belongsTo(SibirRecord::class,'event_id');
    }

    public function video_attendance(){
        return $this->hasMany(OfflineVideoAttendance::class,'video_id');
    }

    public function user_registration() {
        return $this->belongsTo(UserSadhakRegistration::class,"event_id",'sibir_record_id');
    }

    public function chapter() {
        return $this->belongsTo(CourseChapter::class,"course_chapter_id");
    }
}
