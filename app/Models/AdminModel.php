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

class AdminModel extends Model
{
    protected static Rule $rule;

    public function __construct(array $attributes = [] )
    {
        parent::__construct($attributes);
        
       self::$rule = Rule::tryFrom($this->setRole());
    }

    public static function userrole() {
        return self::$rule->role();
    }

    private function setRole(): int {

        $role_id = 0;

        if (auth()->guard('admin')->check() && auth()->guard('web')->check() ) {

            $url = str(url()->current());

            if ($url->contains('admin') ) {
                $role_id = adminUser()->role_id;
            } else {
                $role_id = user()->role_id;
            }
        }

        if (! $role_id ) {

            if (auth()->guard('admin')->check() ) {
                $role_id = adminUser()->role_id;
            } else if(auth()->guard('web')->check()) {
                $role_id = user()->role_id;
            }
        }

        return (int) $role_id;
    }

}
