<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable, SoftDeletes;
    protected $casts = [
        "profileUrl" => "object",
        "address" => "object",
        "created_at" => "datetime",
        "profile" => "object",
        "remarks" => "object"
    ];

    protected $fillable = [
        "full_name",
        "first_name",
        "middle_name",
        "last_name",
        "country",
        'city',
        'address',
        'date_of_birth',
        'email',
        'remember_token',
        'sharing_code',
        'phone_number',
        'profile',
        'gender',
        'street_address'
    ];

    protected $hidden = [
        'stripe_id',
        'pm_last_four',
        'trial_ends_at',
        'password',
        'created_at',
        'updated_at',
        'pm_type',
        'remember_token'
    ];


    public function diskshya()
    {
        return $this->hasMany(MemberDikshya::class);
    }
    public function member_role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function section()
    {
        return $this->hasOne(ProgramStudent::class, "student_id");
    }

    public function meta()
    {
        return $this->hasOne(MemberInfo::class, "member_id");
    }

    public function emergency()
    {
        return $this->hasOne(MemberEmergencyMeta::class, 'member_id')->latest();
    }

    public function emergency_contact()
    {
        return $this->hasMany(MemberEmergencyMeta::class, "member_id");
    }

    public function member_detail()
    {
        return $this->hasMany(ProgramStudent::class, "student_id");
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, "country");
    }


    public function cities()
    {
        return $this->belongsTo(City::class, "city");
    }

    public function refered()
    {
        return $this->hasMany(Reference::class, "referenced_by");
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'member_id');
    }

    public function transactions()
    {
        return $this->hasMany(ProgramStudentFeeDetail::class, 'student_id');
    }

    public function studentFeeOverview()
    {
        return $this->hasOne(ProgramStudentFee::class, "student_id", 'id');
    }
}
