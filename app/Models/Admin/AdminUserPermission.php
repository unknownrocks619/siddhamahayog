<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUserPermission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'module_name',
        'view',
        'edit',
        'delete',
        'added_by'
    ];

    
}
