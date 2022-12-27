<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestAccess extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'program_id',
        'remarks',
        'access_code',
        'meeting_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'access_detail' => 'object'
    ];

    public static function boot()
    {
        parent::boot();
        return static::creating(function ($item) {
            return $item['created_by_user'] = auth()->id();
        });
    }

    public function liveProgram()
    {
        return $this->belongsTo(Live::class, 'meeting_id', 'meeting_id');
    }
}
