<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProgramGrouping extends Model
{
    use HasFactory;

    protected $joins = [];

    public static function singleGrouping(Program $program) {
        $selects = [
            'mem.full_name',
            'mem.email',
            'mem.gotra',
            'mem.phone_number',
            'mem.gender',
            'country.name as country_name',
            'mem.address'
        ];

        $sql = " SELECT ";
        $sql .= implode(", ", $selects);
        $sql .= " FROM programs pro ";

        $sql .= "INNER JOIN program_students prostu
                    ON prostu.program_id = pro.id
                    AND prostu.deleted_at IS NULL
                    AND prostu.active = 1
                ";

        $sql .= "INNER JOIN members mem
                    ON mem.id = prostu.student_id
                    AND mem.deleted_at IS NULL
                    AND mem.role_id NOT IN (1,12,13)
                ";

        $sql .= "LEFT JOIN member_emergency_metas mem_meta
                    ON mem_meta.member_id = mem.id
                    AND mem_meta.contact_type = 'family'
                    AND mem_meta.deleted_at IS NULL
                ";

        $sql .= "LEFT JOIN countries country
                    on country.id = mem.country
                ";
        $sql .= " WHERE ";
        $sql .= 'pro.id = ?';
        $sql .= " AND ";
        $sql .= " mem_meta.contact_type IS NULL ";


        return DB::select($sql,[$program->getKey()]);

    }


    public static function familyGrouping(Program $program) {
        $selects = [
            'mem.full_name',
            'mem.email',
            'mem.gotra',
            'mem.phone_number',
            'mem.gender',
            'country.name as country_name',
            'mem.address',
            'GROUP_CONCAT(mem_meta.contact_person) as family_members',
            'COUNT(mem_meta.id) as total_family_member',
            'GROUP_CONCAT(mem_meta.phone_number) as family_contact_number',
            'GROUP_CONCAT(mem_meta.gender) as family_gender',
            'GROUP_CONCAT(mem_meta.relation) as family_relation'
        ];

        $sql = " SELECT ";
        $sql .= implode(", ", $selects);
        $sql .= " FROM programs pro ";

        $sql .= "INNER JOIN program_students prostu
                    ON prostu.program_id = pro.id
                    AND prostu.deleted_at IS NULL
                    AND prostu.active = 1
                ";

        $sql .= "INNER JOIN members mem
                    ON mem.id = prostu.student_id
                    AND mem.deleted_at IS NULL
                    AND mem.role_id NOT IN (1,12,13)
                ";

        $sql .= "LEFT JOIN member_emergency_metas mem_meta
                    ON mem_meta.member_id = mem.id
                    AND mem_meta.contact_type = 'family'
                    AND mem_meta.deleted_at IS NULL
                ";

        $sql .= "LEFT JOIN countries country
                    on country.id = mem.country
                ";
        $sql .= " WHERE ";
        $sql .= 'pro.id = ?';
        $sql .= " AND ";
        $sql .= " mem_meta.contact_type IS NOT NULL ";
        $sql .= " GROUP BY mem.id";

        return DB::select($sql,[$program->getKey()]);

    }

    public function groupMember() {
        return $this->hasMany(ProgramGroupPeople::class,"group_id");
    }

}
