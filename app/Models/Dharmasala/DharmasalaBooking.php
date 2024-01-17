<?php

namespace App\Models\Dharmasala;

use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DharmasalaBooking extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'room_number',
        'building_id',
        'floor_id',
        'room_id',
        'room_capacity',
        'building_name',
        'floor_name',
        'member_id',
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

}
