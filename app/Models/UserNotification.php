<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserNotification extends Model
{
    use HasFactory,SoftDeletes;

    public function to_user_detail() {
        return $this->belongsto(userDetail::class,"notification_to");
    }

    public function by_user_detail() {
        return $this->belongsTo(userDetail::class,"notification_by");
    }

    public function sibir() {
        $this->belognsTo(SibirRecord::class,"sibir_record_id");
    }
}
