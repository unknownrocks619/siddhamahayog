<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberNotification extends Model
{
    protected $fillable = [
        "member_id",
        "title",
        "body",
        "notification_type",
        "notification_id",
        "type",
        "level",
        "seen"
    ];

    protected $casts = [
        "created_at" => 'datetime',
        "updated_at" => 'datetime'
    ];

    use HasFactory;
}
