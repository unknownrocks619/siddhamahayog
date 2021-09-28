<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoomSetting extends Model
{

    use HasFactory,SoftDeletes;

    public function country(){
        return $this->belongsTo(Countries::class,"country_id");
    }

    public function sibir() {
        return $this->belongsTo(SibirRecord::class,"sibir_record_id");
    }

    public function event_video_class() {
        return $this->hasOne(EventVideoClass::class,'meeting_id','meeting_id');
    }
}
