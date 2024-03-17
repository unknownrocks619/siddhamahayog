<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberEmergencyMeta extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'member_id',
        'contact_person',
        'relation',
        'gender',
        'email_address',
        'phone_number',
        'contact_number',
        'dikshya_type',
    ];

    // protected $casts = [
    //     "contact_person" => "object"
    // ];

    public function member()
    {
        return $this->belongsTo(Member::class, "member_id");
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function profileImage() : HasOneThrough {

        return $this->hasOneThrough(Images::class,ImageRelation::class,'relation_id','id','id','image_id')
                    ->where('relation',self::class)
                    ->where('type','profile_picture')
                    ->latest();
    }


}
