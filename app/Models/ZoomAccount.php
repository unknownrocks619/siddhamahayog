<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        "account_name"
    ];

    protected $hidden = [
        "slug",
        "account_status",
        "account_username",
        "api_token"
    ];

    const ACCESS_TYPES =[
        'admin' => 'Admin',
        'local' => 'Local',
        'zonal' => 'Zonal',
        'other' => 'Other'
    ];

}
