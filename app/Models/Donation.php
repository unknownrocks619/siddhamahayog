<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        "verified",
        "remarks",
        "type",
        'member_id',
        'amount'
    ];

    protected $hidden = [
        "member_id",
        "amount"
    ];

    protected $casts = [
        "remarks" => "object"
    ];
}
