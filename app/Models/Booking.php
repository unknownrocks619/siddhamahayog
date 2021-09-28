<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_detail_id',
        'rooms_id',
        'check_in_date',
        'check_out_date',
        'is_occupied',
        'booking_code',
        'status',
        'is_reserved',
        'remarks',
        'total_duration',
        'created_by_user'
    ];

    public function entry_by(){

        return $this->belongsTo(userDetail::class,'created_by_user');
    }

    public function userdetail(){
        return $this->belongsTo(userDetail::class,"user_detail_id");
    }

    public function room(){
        return $this->belongsTo(Room::class,"rooms_id");
    }
    
    public function check_out_remark(){
        return $this->hasOne(BookingClearance::class,'bookings_id');
    }
}
