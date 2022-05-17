<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;

    public function account() {
        return $this->belongsTo(ZoomAccount::class,"zoom_account_id");
    }
}
