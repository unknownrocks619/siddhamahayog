<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'room_number',
        'room_name',
        'room_type',
        'room_description',
        'room_capacity',
        'room_location',
        'room_category',
        'room_owner_id',
        'created_by_user'
    ];

    public function userdetail(){
        return $this->belongsTo(userDetail::class,'room_owner_id');
    }

    public function occupied_room(){
        return $this->hasMany(Booking::class,'rooms_id')
                    ->where('is_occupied',true)
                    ->orWhere('is_reserved',true);
    }

    public function is_reserved(){
        return $this->hasMany(Booking::class,'rooms_id')
                    ->where('is_reserved',true);
    }
}
