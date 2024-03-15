<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProgramGrouping extends Model
{
    use HasFactory, SoftDeletes;

    protected $joins = [];

    protected $fillable = [
        'program_id',
        'batch_id',
        'group_name',
        'enable_auto_adding',
        'rules',
        'id_card_sample',
        'id_card_print_width',
        'id_card_print_height',
        'id_card_print_position_x',
        'id_card_print_position_y',
        'enable_barcode',
        'barcode_print_width',
        'barcode_print_height',
        'barcode_print_position_x',
        'barcode_print_position_y',
        'enable_personal_info',
        'personal_info_print_width',
        'personal_info_print_height',
        'personal_info_print_position_x',
        'personal_info_print_position_y',
    ];

    protected $casts = [
        'rules' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    const IMAGE_TYPE = 'ID CARD';

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

        /**
     * @return HasOneThrough
     */
    public function memberIDMedia(): HasOneThrough {

        return $this->hasOneThrough(Images::class,ImageRelation::class,'relation_id','id','id','image_id')
            ->where('relation',self::class)
            ->where('type',self::IMAGE_TYPE)
            ->latest();
    }

}
