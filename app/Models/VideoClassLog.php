<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoClassLog extends Model
{
    use HasFactory;

    public function attendee(){
        return $this->hasMany(EventVideoAttendance::class,'video_class_log');
    }
}
