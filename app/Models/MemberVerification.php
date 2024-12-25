<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'otp_code',
        'validation_name'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
