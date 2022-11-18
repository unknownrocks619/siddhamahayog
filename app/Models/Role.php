<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    public static $roles = [
        1 => "Admin",
        2 => "Centers",
        3 => "Sadhaks",
        4 => "Teachers",
        5 => "Admin Teacher",
        6 => "Marketing",
        7 => "Members",
        8 => "Support"
    ];

    protected $casts = [
        'role_category' => 'array'
    ];


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
     */
}
