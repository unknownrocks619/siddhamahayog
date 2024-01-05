<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    use HasFactory;

    protected  $fillable = [
        'id_position',
        'icon',
        'name',
        'order',
        'permission',
        'route',
        'path'
    ];

    protected  $casts = ['permission' => 'array'];
}
