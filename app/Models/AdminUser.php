<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use App\Models\Admin\AdminUserPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
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
 * @property int $id
 * @property int $is_rep
 * @property int|null $center_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Centers|null $center
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, AdminUserPermission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereCenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereIsRep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereIsSuperAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereTagline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser withoutTrashed()
 * @mixin \Eloquent
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
