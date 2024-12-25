<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberEmergencyMeta
 *
 * @property int $id
 * @property int $member_id
 * @property string $contact_person
 * @property string $relation
 * @property string|null $gender
 * @property string|null $email_address
 * @property string $phone_number
 * @property string|null $profile
 * @property string $contact_type
 * @property string|null $gotra
 * @property int|null $confirmed_family
 * @property int|null $verified_family
 * @property string|null $dikshya_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Member $member
 * @property-read \App\Models\Images|null $profileImage
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereConfirmedFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereContactType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereDikshyaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereGotra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta whereVerifiedFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberEmergencyMeta withoutTrashed()
 * @mixin \Eloquent
 */
class MemberEmergencyMeta extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'member_id',
        'contact_person',
        'relation',
        'contact_type',
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
