<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\ProgramStudent
 *
 * @property int $id
 * @property string $program_id
 * @property string|null $program_section_id
 * @property string $student_id
 * @property string|null $batch_id
 * @property int $active
 * @property string|null $roll_number
 * @property int $allow_all
 * @property string|null $multiple_section
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramStudentAttendance> $attendance
 * @property-read int|null $attendance_count
 * @property-read \App\Models\ProgramBatch|null $batch
 * @property-read \App\Models\Live|null $live
 * @property-read \App\Models\Program|null $program
 * @property-read \App\Models\ProgramSection|null $section
 * @property-read \App\Models\Member|null $student
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereAllowAll($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereMultipleSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereProgramSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereRollNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudent withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'program_id',
        'program_section_id',
        'student_id',
        'batch_id',
        'active',
        'roll_number',
        'allow_all',
        'multiple_section'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    public function section()
    {
        return $this->belongsTo(ProgramSection::class, "program_section_id");
    }

    public function batch()
    {
        return $this->belongsTo(ProgramBatch::class, "batch_id");
    }

    public function student()
    {
        return $this->belongsTo(Member::class, "student_id");
    }

    public function live()
    {
        return $this->belongsTo(Live::class, "program_id", "program_id")->where('live', true);
    }

    /**
     * @param int $programID
     * @param int $userID
     * @return bool
     */
    public static function studentExists(int $programID, int $userID): bool
    {

        return ProgramStudent::where('program_id', $programID)
            ->where('student_id', $userID)
            ->exists();
    }

    public function attendance()
    {
        return $this->hasMany(ProgramStudentAttendance::class, 'program_id', 'program_id');
    }

    public static  function all_program_student(Program $program,$searchTerm = null,$limit = null)
    {

        $select = [
            'members.id as user_id', 'members.full_name',
            'members.first_name',
            'members.middle_name',
            'members.last_name',
            'members.email',
            'members.phone_number',
            'program_students.roll_number',
            'program_students.id as program_student_id',
            'program_students.active',
            'program_students.created_at as enrolled_date',
            'program_students.batch_id as student_batch_id',
            'program_sections.section_name',
            'program_sections.id AS section_id'
            // 'batches.batch_name'
        ];

        $binds = [$program->getKey()];
        $columns = implode(',', $select);

        $sql = " SELECT ";
        $sql .= implode(',', $select) ;
        $sql .= " FROM program_students ";

        $sql .= " INNER JOIN members ";
        $sql .= " ON members.id = program_students.student_id ";
        $sql .= " AND members.deleted_at IS NULL ";

        if (! in_array(adminUser()->role(),[Rule::SUPER_ADMIN,Rule::ADMIN])) {
            $sql .= " INNER JOIN center_members cen_mem ";
            $sql .= " ON cen_mem.member_id = members.id ";
            $sql .= " AND cen_mem.center_id = ? ";

            $binds[] = adminUser()->center_id ? adminUser()->center_id :  0;
        }


        $sql .= " LEFT JOIN batches ON batches.id = program_students.batch_id ";
        $sql .= " JOIN program_sections on program_sections.id = program_students.program_section_id";
        $sql .= " WHERE ";
        $sql .= " program_students.program_id = ?";
        $sql .= " AND program_students.deleted_at is NULL";


        if ( $searchTerm ) {
            $sql .= " AND ( ";
                $sql .= " members.first_name LIKE ?";
                $sql .= " OR ";
                $sql .= " members.last_name LIKE ? ";
                $sql .= " OR ";
                $sql .= ' members. email LIKE ?';
                $sql .= " OR ";
                $sql .= " members.phone_number LIKE ?";
                $sql .= " OR ";
                $sql .= " members.full_name LIKE ? ";

            $sql .= ")";

            $binds = array_merge($binds,['%'.$searchTerm.'%','%'.$searchTerm.'%','%'.$searchTerm.'%','%'.$searchTerm.'%','%'.$searchTerm.'%']);
        }

        if ($limit ) {

            $sql .= " LIMIT " . $limit;
        }

        return DB::select($sql,$binds);
    }

    public static function studentPaymentDetail($type = 'admission_fee', $member, Program $program = null)
    {
        if (is_array($member)) {
        }
        $sql = " SELECT * FROM  program_student_fee_details";
        $sql .= " WHERE ";

        if ($type == "admission_fee") {

            $sql .= " amount_category = 'admission_fee' ";
        }

        if (is_array($member) && !empty($member)) {

            $memberID = implode(',', $member);
            $sql .= " AND student_id in ({$memberID})";
        } elseif (is_int($member)) {

            $sql .= " AND student_id in ({$member})";
        }

        if ($program) {

            $sql .= " AND program_id = " . $program->getKey();
        }

        $sql .= " AND program_student_fee_details.deleted_at is NULL";

        $query = <<<SQL
            $sql;
        SQL;

        return DB::select($query);
    }
}
