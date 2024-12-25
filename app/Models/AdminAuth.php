<?php

namespace App\Models;

use App\Classes\Helpers\RoleRule;
use App\Classes\Helpers\Roles\Rule;
use App\Models\Admin\AdminUserPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\AdminAuth
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AdminAuth newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminAuth newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminAuth query()
 * @mixin \Eloquent
 */
class AdminAuth extends Authenticatable
{
    protected static Rule $rule;

    public function __construct(array $attributes = [] )
    {
        parent::__construct($attributes);

    }

    /**
     * Return User Role
     * @return Rule|null
     */
    public static function Role(): Rule|null {
        self::$rule = Rule::tryFrom(adminUser()->role_id);
        return self::$rule->role();

    }
}
