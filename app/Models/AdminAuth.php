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

class AdminAuth extends Authenticatable
{
    protected static Rule $rule;

    public function __construct(array $attributes = [] )
    {
        parent::__construct($attributes);
        
    }

    public static function Role() {
        self::$rule = Rule::tryFrom(adminUser()->role_id);
        return self::$rule->role();

    }
}
