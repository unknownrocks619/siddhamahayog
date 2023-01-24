<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicket extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "media" => "object"
    ];

    public function user()
    {
        return $this->belongsTo(Member::class, "member_id");
    }

    public function staff()
    {
        return $this->belongsTo(Member::class, "replied_by");
    }
}
