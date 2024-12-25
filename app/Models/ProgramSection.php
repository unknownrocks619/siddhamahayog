<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\ProgramSection
 *
 * @property int $id
 * @property string $program_id
 * @property string $section_name
 * @property string $slug
 * @property string $default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CenterMember> $programCenterStudent
 * @property-read int|null $program_center_student_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramStudent> $programStudents
 * @property-read int|null $program_students_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereSectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramSection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProgramSection extends Model
{
    use HasFactory;

    protected  $fillable = [
        'program_id',
        'section_name',
        'slug',
        'default'
    ];

    public function programStudents()
    {
        return $this->hasMany(ProgramStudent::class, "program_section_id");
    }

    public function programCenterStudent(){
        return $this->hasManyThrough(CenterMember::class,ProgramStudent::class,'program_id','member_id','program_id','student_id');
    }

    public function section_student(Program $program, $searchTerm=null) {
        $selects = [
            'prostu.id AS program_student_id',
            'prostu.roll_number',
            'prostu.active as active_student',
            'prostu.created_at as enrolled_date',
            'prostu.roll_number',
            'prostu.allow_all',
            'prostu.batch_id AS batch_id',
            'prostu.program_section_id AS section_id',
            'member.full_name',
            'member.first_name',
            'member.last_name',
            'member.phone_number',
            'member.email',
            'member.id as member_id',
            'member.country as member_country',
            'member.address',
            'memberinfo.personal as personal_detail',
            'country.name as country_name',
            'SUM(prostufee.total_amount) as member_payment',
            'batches.batch_name',
            'scholar.remarks',
            'scholar.scholar_type',
            'scholar.id AS scholarID',
            'section.id AS section_id'
        ];

        $binds = [$program->getKey(),$this->getKey()];

        if ( $program->getKey() == 5 ) {
            $selects[] = 'yagya.total_counter';
        }

        $sql = "SELECT ";
        $sql .= implode(', ', $selects);
        $sql .= ' FROM program_sections section';

        $sql .= ' INNER JOIN program_students prostu';
        $sql .= ' ON prostu.program_section_id = section.id';
        $sql .= ' AND prostu.deleted_at IS NULL';
        $sql .= " AND prostu.program_id = section.program_id";

        $sql .= ' INNER JOIN members member ';
        $sql .= ' ON member.id = prostu.student_id ';
        $sql .= " AND member.deleted_at IS NULL ";

        $sql .= " LEFT JOIN countries country ";
        $sql .= " on member.country = country.id ";

        $sql .= " LEFT JOIN member_infos memberinfo ";
        $sql .= " ON memberinfo.member_id = member.id";

        $sql .= " INNER JOIN program_batches probatch ";
        $sql .= " ON probatch.id = prostu.batch_id ";

        $sql .= " INNER JOIN batches ";
        $sql .= " ON batches.id = probatch.batch_id ";

        $sql .= " LEFT JOIN program_student_fees prostufee ";
        $sql .= " ON prostufee.program_id = section.program_id ";
        $sql .= " AND prostufee.student_id = member.id ";
        $sql .= " AND prostufee.deleted_at IS NULL ";

        $sql .= " LEFT JOIN scholarships scholar";
        $sql .= " ON scholar.program_id = section.program_id ";
        $sql .= " AND scholar.student_id = member.id ";
        $sql .= " AND scholar.deleted_at IS NULL ";

        if ( $program->getKey() == 5 ) {
            $sql .= " LEFT JOIN hanumand_yagya_counters yagya";
            $sql .= " ON yagya.member_id = member.id";
            $sql .= " AND yagya.program_id = section.program_id ";
        }
        if ( ! in_array(adminUser()->role(),[Rule::SUPER_ADMIN,Rule::ADMIN]) ){

            $sql .= " JOIN center_members cen_mem ";
            $sql .= " ON cen_mem.member_id = member.id ";
            $sql .= " AND cen_mem.center_id = " . adminUser()->center_id ?? 0;
        }

        $sql .= " WHERE section.program_id = ? ";
        $sql .= ' AND section.id = ?';

        if ( $searchTerm ) {
            $sql .=  " AND ( ";
            $sql .= " member.full_name LIKE ?";
            $sql .= " OR member.phone_number LIKE ?";
            $sql .= " OR member.email LIKE ? ";
            $sql .= " OR member.first_name LIKE ? ";
            $sql .= " OR member.last_name LIKE ? ";
            $sql .= " OR memberinfo.personal LIKE ?";
            $sql .= " OR country.name LIKE ? ";
            $sql .= " ) ";

            $binds= array_merge($binds, [
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
            ]);

        }

        $sql .= " GROUP BY member.id";
        return DB::select($sql,$binds);

    }

}
