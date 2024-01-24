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


}
