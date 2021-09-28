<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserFamilyGroup extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "sibir_record_id",
        "leader_id",
        "member_id",
        "status",
        'relation',
        "user_sadhak_registration_id",
        "link_type",
        "created_at",
        "updated_at"
    ];

    public function member_detail() {
        return $this->belongsTo(userDetail::class,"member_id");
    }

    public function leader_detail(){
        return $this->belongsTo(userDetail::class,"leader_id");
    }
}
