<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberEmergencyMeta extends Model
{
    use HasFactory, SoftDeletes;

    // protected $casts = [
    //     "contact_person" => "object"
    // ];

    public function member()
    {
        return $this->belongsTo(Member::class, "member_id");
    }
}
