<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSadhakRegistration extends Model
{
    use HasFactory,SoftDeletes;
    use \Awobaz\Compoships\Compoships;

    public function userDetail(){
        return $this->belongsTo(userDetail::class,'user_detail_id');
    }

    public function sadhak_mental_query(){
        return $this->belongsTo(SadhakMentalQueries::class,'sadhak_mental_qurie_id');
    }

    public function branch() {
        return $this->belongsTo(Center::class);
    }

    public function user_preferences(){
        return $this->belongsTo(UserSadhanaCenter::class,'user_sadhak_registration_preference_id');
    }

    public function user_reviews(){
        return $this->hasOne(SadhakReview::class);
    }

    public function sibir_record() {
        return $this->belongsTo(SibirRecord::class,"sibir_record_id");
    }

    public function event_check() {
        return $this->hasOne(EventVideoClass::class,"event_id",'sibir_record_id');
    }

    public function zoom_registration(){
        return $this->hasOne(SadhakUniqueZoomRegistration::class,["sibir_record_id",'user_detail_id'],["sibir_record_id","user_detail_id"]);
    }
}
