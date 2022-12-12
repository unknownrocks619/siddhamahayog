<?php

namespace App\Models\Sadhak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberToSadhak extends Model
{
    use HasFactory;

    protected $casts = [
        'joinHistory' => "object"
    ];
}
