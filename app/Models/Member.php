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

    // public $fillable = [
    //     "full_name",
    //     "first_name",
    //     "middle_name",
    //     "last_name",

    // ]

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

    public function membersByCenters(array $countryIds)
    {
        $countr_ids = implode(', ', $countryIds);
        $query = <<<SQL
                    SELECT * FROM 
                SQL;
    }

    public function cities()
    {
        return $this->belongsTo(City::class, "city");
    }

    public function refered()
    {
        return $this->hasMany(Reference::class, "referenced_by");
    }
}
