<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SadhakUniqueZoomRegistrationArchive extends Model
{

    use HasFactory,SoftDeletes;
    use \Awobaz\Compoships\Compoships;

    protected $fillable = [
        "video_log_id",
        "join_link",
        "user_detail_id",
        "have_joined",
        "joined_at",
        "sibir_record_id",
        "meeting_id",
        "created_at"
    ];

    public function user() {
        return $this->belongsTo(userDetail::class,"user_detail_id");
    }

    public function sibir() {
        return $this->belongsTo(UserSadhakRegistration::class,['sibir_record_id','user_detail_id'],['sibir_record_id','user_detail_id']);
        
    }
}
