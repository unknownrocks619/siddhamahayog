<?php

namespace App\Models;

use App\Models\Dharmasala\DharmasalaBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramGroupPeople extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'full_name',
        'phone_number',
        'address',
        'email',
        'group_uuid',
        'is_card_generated',
        'generated_id_card',
        'profile_id',
        'member_id_card',
        'member_id',
        'program_id',
        'group_id',
        'is_parent',
        'id_parent',
        'parent_relation',
        'dharmasala_booking_id',
        'dharmasala_uuid',
        'access_permission',
        'order',
        'colour'
    ];

    public function families() {
        return $this->hasMany(ProgramGroupPeople::class,'id_parent','id');
    }

    public function parentFamily() {
        return $this->belongsTo(ProgramGroupPeople::class,'id_parent','id');
    }

    public function group() {
        return $this->belongsTo(ProgramGrouping::class,'group_id');
    }

    public function profile() {
        return $this->belongsTo(Images::class,'profile_id');
    }


    public function programGroup() {
        return $this->belongsTo(ProgramGrouping::class,'group_id');
    }

    public function dharmasala() {
        return $this->belongsTo(DharmasalaBooking::class,'dharmasala_booking_id');
    }

    public function program() {
        return $this->belongsTo(Program::class,'program_id');
    }
}
