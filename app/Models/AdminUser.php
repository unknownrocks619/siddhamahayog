<?php

namespace App\Models;

use App\Models\Admin\AdminUserPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'tagline',
        'is_super_admin',
        'active',
    ];

    public const IS_SUPER_ADMIN = 1;

    public function full_name() {
        return $this->firstname .' ' . $this->lastname;
    }

    public function isSuperAdmin() {
        return $this->is_super_admin === self::IS_SUPER_ADMIN;
    }

    public function permissions() {
        return $this->hasMany(AdminUserPermission::class,'user_id');
    }
}
