<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSewaBridge extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_sewas_id',
        'user_involvement',
        'created_by_user',
        'bookings_id'
    ];

    public function usersewa()
    {
        return $this->belongsTo(UserSewa::class,'user_sewas_id');
    }

    public function booking(){
        return $this->belongsTo(Booking::class,'bookings_id');
    }
}
