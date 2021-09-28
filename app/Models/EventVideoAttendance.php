<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventVideoAttendance extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'event_class_id',
        "user_id",
        "is_active",
        "created_at",
        "updated_at",
        "video_class_log",
        "source",
        "zonal_setting_id",
        "meeting_id"
    ];

    public function event_class(){
        return $this->belongsTo(SibirRecord::class,'event_class_id');
    }

    public function user_detail(){
        return $this->belongsTo(userDetail::class,"user_id");
    }
}
