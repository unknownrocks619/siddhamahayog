<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DharmasalaBookingLogs extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'booking_id',
        'original_content',
        'changed_content',
        'original_type_value',
        'change_type_value',
        'type',
        'updated_by'
    ];

    protected $casts = [
        'original_content'  => 'array',
        'changed_content'   => 'array',
        'original_type_value'   => 'array',
        'change_type_value' => 'array'
    ];
}
