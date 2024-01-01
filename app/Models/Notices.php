<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notices extends Model
{
    use HasFactory,SoftDeletes;

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

    const TYPES = [
        'text'  => 'Text',
        'image' => "Image / File",
        'video' => 'Video',
    ];
}
