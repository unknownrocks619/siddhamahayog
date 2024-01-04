<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberRefers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'full_name',
        'phone_number',
        'relation',
        'country',
        'email_address',
        'remarks',
        'status',
        'converted_id',
        'approved_date'
    ];

    const STATUS_OPTION = [
        'pending'   => "Pending",
        'follow-up' => 'Processing',
        'cancelled' => 'Cancelled',
        'approved'  => 'Approved'
    ];

    const STATUS_DISPLAY = [
      'pending' => '<span class="badge bg-label-primary">Pending</span>',
      'follow-up'   => "<span class='badge bg-label-info'>Processing</span>",
      'cancelled'   => '<span class="badge bg-label-danger">Cancelled</span>',
      'approved'  => '<span class="badge bg-label-success">Approved</span>'
    ];
}
