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
        'diskhya_type',
        'rashi_name'
    ];
    protected $casts = [
        'remarks' => 'object'
    ];
}
