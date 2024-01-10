<?php

namespace App\Models\Dharmasala;

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
        'check_out',
        'profile',
        'id_card',
        'status'
    ];


}
