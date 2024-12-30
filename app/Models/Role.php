<?php

namespace App\Models;

use App\Classes\Helpers\RoleRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $role_name
 * @property string $role_slug
 * @property string|null $modules
 * @property array $role_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereModules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRoleCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRoleSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    use HasFactory;

    public static $roles = [
        1 => "Super Admin",
        2 => "Centers",
        3 => "Sadhaks",
        4 => "Teachers",
        5 => "Admin Teacher",
        6 => "Marketing",
        7 => "Members",
        8 => "Support",
        9 => "CenterAdmin",
        10 => "Dharmashala",
        11 => "Co-Host",
        12 => 'Acting-Admin',
        13 => 'Admin'
    ];
    public const DHARMASHALA = 10;
    public const ACTING_ADMIN = 12;
    public const SUPER_ADMIN = 1;
    public const ADMIN = 13;
    public const CENTER_ADMIN = 9;
    public const SUPPORT = 8;
    public const CENTER = 2;
    public const MEMBER = 7;
    public const TEACHER = 4;

    protected $casts = [
        'role_category' => 'array'
    ];

    public const ADMIN_DASHBOARD_ACCESS = [
        self::ADMIN,
        self::SUPER_ADMIN,
        self::ACTING_ADMIN
    ];

    public const CENTER_USER_ADD_LIST = [
        self::CENTER
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


    /**
     * Return Authorized Center for user
     */
    public function authorizedCountry(array $countryId)
    {
        $country_id = implode(', ', $countryId);
        $sql = <<<SQL
                    SELECT country.id, country.name
                        FROM country
                    WHERE country.id IN ($country_id);
                SQL;
        return DB::select($sql);
    }

    /**
     * 1 => ADMIN
     * 2 => CENTERS
     * 3 => SADHAKS
     * 4 => TEACHERS
     * 5 => ADMIN_TEACHER
     * 6 => MARKETING
     * 7 => MEMBERS
     * 8 => "Support",
     * 9 => "CenterAdmin",
     * 10 => "Dharmashala"
     */
}
