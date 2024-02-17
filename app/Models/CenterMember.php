<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterMember extends Model
{
    protected $fillable = [
        'member_id',
        'center_id'
    ];

    
}
