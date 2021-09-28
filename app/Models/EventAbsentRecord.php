<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAbsentRecord extends Model
{
    use HasFactory;

    public function user_detail(){
        return $this->belongsTo(userDetail::class,"user_detail_id");
    }
}
