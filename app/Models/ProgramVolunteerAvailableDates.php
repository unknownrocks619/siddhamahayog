<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramVolunteerAvailableDates extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'member_id',
        'program_volunteer_id',
        'available_dates',
        'status',
    ];
}
