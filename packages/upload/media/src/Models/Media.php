<?php

namespace Upload\Media\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $casts = [
        "media" => 'object',
        "type" => 'object'
    ];
}
