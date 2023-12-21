<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDikshya extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'remarks',
        'dikshya_type',
        'rashi_name',
        'ceromony_location',
        'ceromony_date',
        'guru_name'
    ];

    protected $casts = [
        'remarks' => 'array'
    ];
}
