<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DonationTransaction extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_detail_id',
        'source',
        'donation_amount',
        'bookings_id',
        'remark',
        'created_by_user'
    ];
    
    public function booking(){
        return $this->belongsTo(Booking::class,'bookings_id');
    }
}
