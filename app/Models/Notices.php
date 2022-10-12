<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notices extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "notice",
        "notice_type",
        "settings",
        "active",
        "target",
        "program_id",
        "section_id",
    ];
    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => 'datetime',
        "settings" => "object"
    ];
}
