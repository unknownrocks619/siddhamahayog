<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberRefers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'member_id',
        'full_name',
        'phone_number',
        'relation',
        'country',
        'email_address',
        'remarks',
        'status',
        'converted_id',
        'approved_date'
    ];
}
