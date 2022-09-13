<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $casts = [
        "media" => "object"
    ];

    public function user()
    {
        return $this->belongsTo(Member::class, "member_id");
    }
}
