<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "history" => "object",
        "education" => "object",
        "personal" => "object",
        'remarks' => 'object'
    ];
}
