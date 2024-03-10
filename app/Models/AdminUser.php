<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use App\Models\Admin\AdminUserPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * 
 * Admin User Model
 * 
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property string $tagline
 * @property bool $is_super_admin
 * @property bool $active
 * @property int $role_id
 * 
 * 
 */

class AdminUser extends AdminAuth
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
        'role_id',
        'is_rep',
        'center_id'
    ];

    public const IS_SUPER_ADMIN = 1;

    public function full_name(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function isSuperAdmin()
    {
        return $this->is_super_admin === self::IS_SUPER_ADMIN;
    }

    public function permissions()
    {
        return $this->hasMany(AdminUserPermission::class, 'user_id');
    }

    public function center() {
        return $this->belongsTo(Centers::class,'center_id');
    }
}
