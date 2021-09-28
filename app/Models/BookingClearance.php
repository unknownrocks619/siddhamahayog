<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingClearance extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'bookings_id',
        'booking_code',
        'remarks',
        'created_by_user'
    ];

    public function entry_by(){

        return $this->belongsTo(userDetail::class,'created_by_user');
    }
}
