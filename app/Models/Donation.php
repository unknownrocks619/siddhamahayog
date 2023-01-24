<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

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
