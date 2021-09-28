<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventFund extends Model
{
    use HasFactory,SoftDeletes;

    public function user_detail() {
        return $this->belongsTo(userDetail::class,"user_detail_id");
    }

    public function fund_detail() {
        return $this->hasMany(EventFundDetail::class,"event_fund_id");
    }
}
