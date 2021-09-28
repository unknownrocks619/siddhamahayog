<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineVideo extends Model
{
    use HasFactory;

    public function event_source() {
        return $this->belongsTo(SibirRecord::class,'event_id');
    }

    public function video_attendance(){
        return $this->hasMany(OfflineVideoAttendance::class,'video_id');
    }

    public function user_registration() {
        return $this->belongsTo(UserSadhakRegistration::class,"event_id",'sibir_record_id');
    }
}
