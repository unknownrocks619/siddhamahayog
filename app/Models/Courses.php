<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    use HasFactory,SoftDeletes;

    public function total_enrolled() {
        return $this->hasMany(UserSadhakRegistration::class,'sibir_record_id','sibir_record_id');
    }

    public function user_detail(){
        return $this->belongsTo(userDetail::class,"user_detail_id");
    }
}
