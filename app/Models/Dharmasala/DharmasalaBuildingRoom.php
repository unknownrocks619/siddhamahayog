<?php

namespace App\Models\Dharmasala;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
