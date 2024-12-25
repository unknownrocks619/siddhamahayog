<?php

namespace App\Models\Dharmasala;

use App\Models\DharmasalaAmenity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Dharmasala\DharmasalaBuildingRoom
 *
 * @property int $id
 * @property string $room_number
 * @property int|null $building_id
 * @property int|null $floor_id
 * @property int|null $room_capacity
 * @property string|null $room_name
 * @property string $room_description
 * @property string|null $room_prefix
 * @property string|null $searchable_room
 * @property string $room_type available options: single, twin, double, hall, open
 * @property array|null $amenities
 * @property string $room_category available type: general, reserved,vip,paid
 * @property int $is_available
 * @property int $online
 * @property int $enable_booking
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Dharmasala\DharmasalaBuilding|null $building
 * @property-read \App\Models\Dharmasala\DharmasalaBuildingFloor|null $floor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dharmasala\DharmasalaBooking> $totalActiveReserved
 * @property-read int|null $total_active_reserved_count
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom query()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereAmenities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereEnableBooking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereFloorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereRoomCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereRoomCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereRoomDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereRoomName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereRoomNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereRoomPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereRoomType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereSearchableRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingRoom withoutTrashed()
 * @mixin \Eloquent
 */
class DharmasalaBuildingRoom extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'room_number',
        'building_id',
        'floor_id',
        'room_capacity',
        'room_name',
        'room_description',
        'room_type',
        'amenities',
        'room_category',
        'is_available',
        'online',
        'enable_booking',
    ];

    public const ROOM_STATUS = [
        'available' => 'Available',
        'under_maintenance' => 'Under Maintenance',
        'closed'    => 'Closed'
    ];

    public const ROOM_TYPES = [
        'single'    => 'Single',
        'double'    => 'Double',
        'twin'      => 'Twin',
        'hall'      => 'Hall',
        'open'      => 'Open'
    ];

    public const ROOM_CATEGORY = [
        'general'   => 'General',
        'reserved'  => 'Reserved',
        'vip'       => 'VIP',
        'guest'     => 'Guest',
        'paid'      => 'Paid'
    ];

    public $casts = [
        'amenities' => 'array'
    ];

    public function roomAmenities(){
        // $amenities = $this->amenities;
        // if ( ! $$amenities ) {
        //     $amenities = [];
        // }

        return DharmasalaAmenity::whereIn('id', $this->amenities ?? [])->get();
    }

    public function building() {
        return $this->belongsTo(DharmasalaBuilding::class,'building_id');
    }

    public function floor() {
        return $this->belongsTo(DharmasalaBuildingFloor::class,'floor_id');
    }

    public function totalActiveReserved() {
        return $this->hasMany(DharmasalaBooking::class,'room_id')
                    ->whereIn('status',[DharmasalaBooking::BOOKING,DharmasalaBooking::RESERVED,DharmasalaBooking::CHECKED_IN]);
    }

}
