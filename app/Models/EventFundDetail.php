<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventFundDetail extends Model
{
    use HasFactory,SoftDeletes;

    public function user_detail() {
        return $this->belongsTo(userDetail::class,"user_detail_id");
    }

    public function sibir () {
        return $this->belongsTo(SibirRecord::class,"sibir_record_id");
    }

    public function image_file(){
        return $this->hasOne(Uploader::class,"id","file");
    }
}
