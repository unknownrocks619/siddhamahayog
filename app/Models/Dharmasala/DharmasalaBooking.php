<?php

namespace App\Models\Dharmasala;

use App\Classes\Helpers\Roles\Rule;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Images;
use App\Models\ImageRelation;

/**
 * App\Models\Dharmasala\DharmasalaBooking
 *
 * @property int $id
 * @property int|null $id_parent
 * @property int|null $building_id
 * @property int|null $floor_id
 * @property int $room_id
 * @property int|null $member_id
 * @property int|null $member_emergency_meta_id
 * @property string $room_number
 * @property string|null $building_name
 * @property string|null $floor_name
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $check_in
 * @property string|null $check_in_time
 * @property string|null $check_out
 * @property string|null $check_out_time
 * @property Images|null $profile
 * @property string|null $id_card
 * @property int $status 1 : reserved, 2: In, 3 : Out, 4: Canceled, 5: booking, 6: processing, 7: Legacy
 * @property string|null $relation_with_parent
 * @property string|null $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Images|null $IDImage
 * @property-read Images|null $idCardImage
 * @property-read DharmasalaBooking|null $parentBooking
 * @property-read Images|null $profileImage
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereBuildingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereCheckIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereCheckInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereCheckOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereCheckOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereFloorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereFloorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereMemberEmergencyMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereRelationWithParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereRoomNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBooking withoutTrashed()
 * @mixin \Eloquent
 */
class DharmasalaBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'id_parent',
        'room_number',
        'building_id',
        'floor_id',
        'room_id',
        'room_capacity',
        'building_name',
        'floor_name',
        'member_id',
        'member_emergency_meta_id',
        'full_name',
        'email',
        'phone_number',
        'check_in',
        'check_in_time',
        'check_out',
        'check_out_time',
        'profile',
        'id_card',
        'status',
        'relation_with_parent',
        'uuid'
    ];

    public const STATUS = [
        1 => 'Reserved',
        2 => 'Checked In',
        3 => 'Checked Out',
        4 => 'Cancelled',
        5 => 'Booking',
        6 => 'Processing',
        7 => 'Legacy' // should be used
    ];

    public const RESERVED = 1;
    public const CHECKED_IN = 2;
    public const CHECKED_OUT = 3;
    public const CANCELLED=4;
    public const BOOKING=5;
    public const PROCESSING=6;
    public const LEGACY = 7;

    public const ACCESS =[
        Rule::DHARMASALA,
        Rule::ADMIN,
        Rule::SUPER_ADMIN,
    ];

    const IMAGES = [
        'profile'   => "Profile Image",
        'id'    => 'ID Image'
    ];

    public function getChildBookings() {
        return $this->hasMany(DharmasalaBooking::class,'id_parent','id');
    }

    public function profileImage() {
        return $this->belongsTo(Images::class,'profile');
    }

    public function idCardImage() {
        return $this->belongsTo(Images::class,'id_card');
    }

    public function profile() {
        return $this->hasOneThrough(Images::class,ImageRelation::class,'relation_id','id')
            ->where('relation',self::class)
            ->where('type','profile')
            ->latest();
    }

    public function IDImage() {
        return $this->hasOneThrough(Images::class,ImageRelation::class,'relation_id','id')
            ->where('relation',self::class)
            ->where('type','id')
            ->latest();
    }

    public function parentBooking() {
        return $this->belongsTo(self::class,'id_parent');
    }
}
