<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramGroupPeople extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'full_name',
        'phone_number',
        'email',
        'group_uuid',
        'is_card_generated',
        'profile_id',
        'member_id',
        'program_id',
        'group_id',
        'is_parent',
        'dharmasala_booking_id',
        'dharmasala_uuid',
        'access_permission',
        'order',
        'colour'
    ];

    public function families() {
        return $this->hasMany(ProgramGroupPeople::class,'id_parent','id');
    }

}
