<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventVideoClass extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $fillable =[
        'event_id',
        'class_start',
        'class_end',
        'is_active',
        'meeting_id',
        'password',
        'video_link',
        'class_source',
    ];
    
    public function event_source(){
        return $this->belongsTo(SibirRecord::class,"event_id");
    }

    public function total_session(){
        return $this->hasMany(VideoClassLog::class,"event_video_class_id");
    }

    public function user_detail() {
        return $this->belongsTo(userDetail::class,'some_id');
    }
}
