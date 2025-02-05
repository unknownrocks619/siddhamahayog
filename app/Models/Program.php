<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Program Model
 *
 * @property string $program_duration
 * @property string|null $program_access
 * @property string|null $admission_fee
 * @property string|null $monthly_fee
 * @property string $program_start_date
 * @property string $program_end_date
 * @property string|null $promote
 * @property string $description
 * @property float|int $overdue_allowed
 * @property int $batch
 * @property int $zoom
 * @property int $id
 * @property string $program_name
 * @property string $slug
 * @property string $program_type
 * @property string|null $meeting_id
 * @property string $status available options: pending, active, close, inactive, review
 * @property array|null $admin_access_permission
 * @property array|null $admin_detail_permission
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\ProgramBatch|null $active_batch
 * @property-read \App\Models\ProgramCourseFee|null $active_fees
 * @property-read \App\Models\ProgramSection|null $active_sections
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Live> $allLivePrograms
 * @property-read int|null $all_live_programs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramBatch> $batches
 * @property-read int|null $batches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramCourseResources> $courses
 * @property-read int|null $courses_count
 * @property-read \App\Models\Batch|null $defaultBatch
 * @property-read \App\Models\LessionWatchHistory|null $last_video_history
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Live> $liveProgram
 * @property-read int|null $live_program_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Batch> $programBatches
 * @property-read int|null $program_batches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramChapterLession> $program_videos
 * @property-read int|null $program_videos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramSection> $sections
 * @property-read int|null $sections_count
 * @property-read \App\Models\ProgramStudentFeeDetail|null $student_admission_fee
 * @property-read \App\Models\ProgramStudentFee|null $student_fee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramStudent> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramCourse> $videoCourses
 * @property-read int|null $video_courses_count
 * @method static \Illuminate\Database\Eloquent\Builder|Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program query()
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereAdminAccessPermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereAdminDetailPermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereAdmissionFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereMonthlyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereOverdueAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereProgramAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereProgramDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereProgramEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereProgramName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereProgramStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereProgramType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program wherePromote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereZoom($value)
 * @mixin \Eloquent
 */
class Program extends AdminModel
{
    use HasFactory;

    protected string $foreignKey = "program_id";

    protected $auditable = [
        'program_name' => 'Program Name'
    ];
    protected  $fillable = [
        'program_duration',
        'program_access',
        'admission_fee',
        'monthly_fee',
        'program_start_date',
        'program_end_date',
        'promote',
        'description',
        'overdue_allowed',
        'batch',
        'zoom',
        'slug',
        'program_name',
        'program_type',
        'admin_access_permission',
        'admin_detail_permission'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'zoom',
        'admission_fee',
        'monthly_fee',
        'program_access',
    ];

    protected $alias = [
        'id' => "Program ID"
    ];

    protected $casts = [
        'admin_detail_permission' => 'array',
        'admin_access_permission'   => 'array'
    ];
    public const PROGRAM_TYPES = [
        'open' => 'Open',
        'paid'  => 'Paid',
        'live'  => 'Live',
        'registered_user' => "Registered User",
        'club'  => 'Club',
        'sadhana'   => 'Sadhana',
        'event' => 'Event'
    ];

    public const PROGRAM_STATUS = [
        'active'    =>  'Active',
        'pending'   => 'Pending',
        'inactive'  => 'Inactive'
    ];

    public const GO_LIVE_ACCESS = [
        Rule::SUPER_ADMIN,
        Rule::ADMIN,
        Rule::ACTING_ADMIN,
    ];

    public const EDIT_PROGRAM_ACCESS = [
        Rule::SUPER_ADMIN,
        Rule::ADMIN
    ];

    public const STUDENT_COUNT_ACCESS = [
        Rule::SUPER_ADMIN,
        Rule::ADMIN
    ];

    public const QUICK_NAVIGATION_ACCESS = [
        'syllabus_and_resources'    => [
            'label' => 'Syllabus / Resources',
            'access'    => [Rule::SUPER_ADMIN, Rule::ACTING_ADMIN, Rule::ADMIN]
        ],
        'program_daily_attendance'  => [
            'label' => 'Program Daily Attendance',
            'access'    => [Rule::SUPER_ADMIN, Rule::ADMIN]
        ],
        'account_and_management' => [
            'label' => 'Account Management',
            'access'    => [Rule::SUPER_ADMIN, Rule::CENTER_ADMIN, Rule::CENTER]
        ],

        'assign_member_to_program'  => [
            'label' => 'Assign Member to Program',
            'access'    => [Rule::SUPER_ADMIN, Rule::ADMIN]
        ],
        'register_new_member_to_program'    => [
            'label' => 'Register Member',
            'access'    => [Rule::SUPER_ADMIN, Rule::ADMIN, Rule::CENTER_ADMIN, Rule::CENTER]
        ],
        'scholarship_and_special_permission' => [
            'label' => 'Scholarship & Special Permission',
            'access'    => [Rule::SUPER_ADMIN, Rule::ADMIN]
        ],
        'vip_and_guest_list'    => [
            'label' => 'VIP / Guest Access List',
            'access'    => [Rule::SUPER_ADMIN, Rule::ADMIN]
        ],
        'grouping'  => [
            'label' => 'Group',
            'access'    => [Rule::SUPER_ADMIN]
        ],
        'volunteer' => [
            'label' => 'Volunteer For Program',
            'access'    => [Rule::SUPER_ADMIN, Rule::ADMIN]
        ]
    ];

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, $this->foreignKey);
    }

    public function program_active_student()
    {
        return $this->hasOne(ProgramStudent::class, $this->foreignKey)
            ->where('student_id', user()->getKey())
            ->where('active', true)->first();
    }

    /**
     * Active Batch Group
     */
    public function active_batch()
    {
        return $this->hasOne(ProgramBatch::class, $this->foreignKey)->where('active', true)->latest();
    }

    /**
     * List all available batches for a program
     */
    public function batches()
    {
        return $this->hasMany(ProgramBatch::class, $this->foreignKey);
    }

    /**
     * List all  videos for a program.
     */
    public function program_videos()
    {
        return $this->hasMany(ProgramChapterLession::class, $this->foreignKey);
    }

    /**
     * List all video courses for a program.
     */
    public function videoCourses()
    {
        return $this->hasMany(ProgramCourse::class, $this->foreignKey);
    }

    /**
     * List all course / syllabus
     */
    public function courses()
    {
        return $this->hasMany(ProgramCourseResources::class, $this->foreignKey);
    }

    /**
     * List current rule for fee structure.
     */
    public function active_fees()
    {
        return $this->hasOne(ProgramCourseFee::class, $this->foreignKey)->latest();
    }

    /**
     * List over all fee of the student.
     */
    public function student_fee()
    {
        return $this->hasOne(ProgramStudentFee::class, $this->foreignKey);
    }

    /**
     * Active Section for a program.
     */
    public function active_sections()
    {
        return $this->hasOne(ProgramSection::class, $this->foreignKey)->where('default', true);
    }

    /**
     * List all available sections
     */
    public function sections()
    {
        return $this->hasMany(ProgramSection::class, $this->foreignKey);
    }

    /**
     * User last watched videos.
     */
    public function last_video_history()
    {
        return $this->hasOne(LessionWatchHistory::class, $this->foreignKey)->where('student_id', auth()->id())->latest();
    }

    /**
     * Retrieve admission fee for the student.
     */
    public function student_admission_fee()
    {
        return $this->hasOne(ProgramStudentFeeDetail::class, $this->foreignKey)->where('student_id', auth()->id())->where('amount_category', 'admission_fee')->where('verified', true);
    }


    /**
     * Retrieve admission fee for the student.
     */
    public function admission_fee()
    {
        return $this->hasOne(ProgramStudentFeeDetail::class, $this->foreignKey)->where('student_id', auth()->id())->where('amount_category', 'admission_fee')->latest();
    }


    public function liveProgram()
    {
        return $this->hasMany(Live::class, "program_id")->where('live', true);
    }

    public function allLivePrograms()
    {
        return $this->hasMany(Live::class, "program_id")->where('live', true);
    }

    public function defaultBatch()
    {
        return $this->hasOne(Batch::class, 'id', 'batch');
    }

    public function programStudentEnrolments($searchTerm = null)
    {
        $selects = [
            'pro.program_name',
            'pro.id AS program_id',
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
            'member.gotra',
            'member.address',
            'memberinfo.personal as personal_detail',
            'country.name as country_name',
            'SUM(prostufee.total_amount) as member_payment',
            'prosec.section_name',
            'batches.batch_name',
            'scholar.remarks',
            'scholar.scholar_type',
            'scholar.id AS scholarID',
        ];

        $binds = [$this->getKey()];

        if ($this->getKey() == 5) {
            $selects[] = 'yagya.total_counter';
        }

        $sql = "SELECT ";
        $sql .= implode(', ', $selects);
        $sql .= ' FROM programs pro';

        $sql .= ' INNER JOIN program_students prostu';
        $sql .= ' ON prostu.program_id = pro.id';
        $sql .= ' AND prostu.deleted_at IS NULL';

        $sql .= ' INNER JOIN members member';
        $sql .= ' ON member.id = prostu.student_id';
        $sql .= " AND member.deleted_at IS NULL";

        if (! in_array(adminUser()->role(), [Rule::SUPER_ADMIN, Rule::ADMIN])) {

            $sql .= " INNER JOIN center_members cen_mem ";
            $sql .= " ON cen_mem.member_id = member.id";
            $sql .= " AND cen_mem.center_id =   ";

            $sql .= adminUser()->center_id ? adminUser()->center_id : 0;
        }

        $sql .= ' LEFT JOIN countries country ';
        $sql .= " on member.country = country.id";

        $sql .= " LEFT JOIN member_infos memberinfo ";
        $sql .= " on memberinfo.member_id = member.id";

        $sql .= ' INNER JOIN program_sections prosec';
        $sql .= ' ON prosec.id = prostu.program_section_id';
        $sql .= " AND prosec.deleted_at IS NULL";

        $sql .= ' INNER JOIN program_batches probatch';
        $sql .= ' ON probatch.id = prostu.batch_id';

        $sql .= ' INNER JOIN batches';
        $sql .= " ON batches.id = probatch.batch_id";

        $sql .= " LEFT JOIN program_student_fees prostufee";
        $sql .= " ON prostufee.program_id = pro.id";
        $sql .= " AND prostufee.student_id = member.id";
        $sql .= " AND prostufee.deleted_at IS NULL";

        $sql .= " LEFT JOIN scholarships scholar";
        $sql .= " ON scholar.program_id = pro.id";
        $sql .= " AND scholar.student_id = member.id";
        $sql .= " AND scholar.deleted_at IS NULL ";

        if ($this->getKey() == 5) {
            $sql .= " LEFT JOIN hanumand_yagya_counters yagya";
            $sql .= " ON yagya.member_id = member.id";
            $sql .= " AND yagya.program_id = pro.id ";
        }

        $sql .= " WHERE pro.id = ?";

        if ($searchTerm) {
            $sql .=  " AND ( ";
            $sql .= " member.full_name LIKE ?";
            $sql .= " OR member.phone_number LIKE ?";
            $sql .= " OR member.email LIKE ? ";
            $sql .= " OR member.first_name LIKE ? ";
            $sql .= " OR member.last_name LIKE ? ";
            $sql .= " OR memberinfo.personal LIKE ?";
            $sql .= " OR country.name LIKE ? ";
            $sql .= " ) ";

            $binds = array_merge($binds, [
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
            ]);
        }

        $sql .= " GROUP BY member.id";

        return DB::select($sql, $binds);
    }

    public function totalAdmissionFee()
    {

        $sql  = " SELECT SUM(amount) as total_amount, ";
        $sql .= "  COALESCE(amount_category, 'grand_total') AS total_by";
        $sql .= " FROM program_student_fee_details prostufee";
        $sql .= " WHERE prostufee.verified  = 1";
        $sql .= " AND prostufee.program_id = ? ";
        $sql .= " AND prostufee.deleted_at IS NULL ";

        if (adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin()) {
            $sql .= " AND prostufee.fee_added_by_center = ";
            $sql .= adminUser()->center_id ? adminUser()->center_id : 0;
        }

        $sql .=  " GROUP BY prostufee.amount_category ";
        $sql .= " WITH ROLLUP";

        return DB::select($sql, [$this->getKey()]);
    }

    public function programBatches()
    {
        return $this->hasManyThrough(Batch::class, ProgramBatch::class, 'program_id', 'id', 'id', 'batch_id');
    }

    public function totalRevenue() {}


    public function transactionOverview($term = null)
    {
        $selects = [
            'fees.student_id',
            'fees.id as fees_id',
            'fees.total_amount as amount',
            'fees.updated_at as last_transaction_date',
            'member.full_name',
            'member.id as member_id',
        ];

        $binds = [$this->getKey()];

        $sql = " SELECT ";
        $sql .= implode(" , ", $selects);
        $sql .= " FROM  program_student_fees fees";
        $sql .= " JOIN members member ";
        $sql .= " ON member.id = fees.student_id";
        $sql .= ' AND member.deleted_at IS NULL ';

        $sql .= " WHERE fees.program_id = ?";
        $sql .= " AND fees.deleted_at IS NULL ";

        if ($term) {
            $sql .= " AND ( ";
            $sql .= 'member.first_name LIKE ?';
            $sql .= " OR ";
            $sql .= " member.last_name LIKE ? ";
            $sql .= " OR ";
            $sql .= " member.email LIKE ? ";
            $sql .= " OR ";
            $sql .= " member.phone_number LIKE ?";
            $sql .= ' OR ';
            $sql .= "fees.total_amount >= ?";
            $sql .= " ) ";

            $binds = array_merge(
                $binds,
                [
                    '%' . $term . '%',
                    '%' . $term . '%',
                    '%' . $term . '%',
                    '%' . $term . '%',
                    $term
                ]
            );
        }

        return DB::select($sql, $binds);
    }
    public function transactionsDetail($searchTerm = null, array $filters = [])
    {
        $selects = [
            'fee_detail.id as transaction_id',
            'fee_detail.program_student_fees_id as transaction_overview_id',
            'fee_detail.amount',
            'fee_detail.amount_category',
            'fee_detail.exchange_rate',
            'fee_detail.foreign_currency_amount',
            'fee_detail.currency',
            'fee_detail.source',
            'fee_detail.source_detail',
            'fee_detail.verified',
            'fee_detail.rejected',
            'fee_detail.remarks',
            'fee_detail.file',
            'fee_detail.voucher_number',
            'fee_detail.created_at as transaction_date',
            'fee_detail.fee_added_by_user as staff_id',
            'fee_detail.fee_added_by_center as center_id',
            'fee_detail.is_marked_to_print',
            'center.center_name',
            'CONCAT(admin.firstname," ",admin.lastname) as staff_name',
            'member.full_name',
            'member.email',
            'member.phone_number',
            'member.id as member_id',
            'pu.request_type',
            'pu.status as pending_request_status',
            'pu.relation_table',
            'img.filepath as transaction_file',

        ];
        $binds = [$this->getKey()];

        $sql = " SELECT ";
        $sql .= implode(' , ', $selects);
        $sql .= " FROM program_student_fee_details fee_detail";

        $sql .= " JOIN members member";
        $sql .= " ON member.id = fee_detail.student_id";

        if (! in_array(adminUser()->role(), [Rule::SUPER_ADMIN, Rule::ADMIN])) {
            $sql .= ' JOIN center_members cen_mem ';
            $sql .= ' ON cen_mem.member_id = member.id ';
        } else {
            if (isset($filters['admin'])) {
                $sql .= " JOIN admin_users admin ";
                $sql .= " ON admin.id = fee_detail.fee_added_by_user";
                $sql .= " AND admin.id = " . $filters['admin'];
            } else {
                $sql .= " LEFT JOIN admin_users admin ";
                $sql .= " ON admin.id = fee_detail.fee_added_by_user";
            }

            if (isset($filters['center'])) {
                $sql .= " JOIN centers center ";
                $sql .= " ON center.id = fee_detail.fee_added_by_center";
                $sql .= " AND center.id = " . $filters['center'];
            } else {
                $sql .= " LEFT JOIN centers center ";
                $sql .= " ON center.id = fee_detail.fee_added_by_center";
            }
        }

        $sql .= " LEFT JOIN permission_updates pu";
        $sql .= " ON pu.relation_id = fee_detail.id";
        $sql .= " AND pu.status = " . PermissionUpdate::STATUS_PENDING;

        $sql .= " LEFT JOIN image_relations imr ";
        $sql .= ' ON imr.relation_id = fee_detail.id';
        $sql .= ' AND imr.relation = "App\\\Models\\\ProgramStudentFeeDetail"';
        $sql .= " AND imr.deleted_at IS NULL ";

        $sql .= " LEFT JOIN images img ";
        $sql .= ' ON img.id = imr.image_id';
        $sql .= ' AND img.deleted_at IS NULL ';

        $sql .= " WHERE fee_detail.program_id = ? ";

        if (isset($filters['amount']['value']) && isset($filters['amount']['operator'])) {
            $sql .= ' AND amount ' . $filters['amount']['operator'] . ' ' . $filters['amount']['value'];
        }

        if ($searchTerm) {

            $sql .= " AND ( ";
            $sql .= " LOWER(member.full_name) LIKE ? ";
            $sql .= " OR member.first_name LIKE ?";
            $sql .= " OR member.last_name LIKE ?";
            $sql .= " OR member.email LIKE ? ";
            $sql .= " OR member.phone_number LIKE ? ";
            $sql .= " OR fee_detail.created_at LIKE ? ";
            $sql .= " OR fee_detail.source_detail LIKE ? ";
            $sql .= " OR fee_detail.source LIKE ? ";
            $sql .= " OR fee_detail.amount_category LIKE ? ";
            $sql .= " OR fee_detail.amount LIKE ? ";
            $sql .= ' OR fee_detail.voucher_number LIKE ? ';
            if (in_array(adminUser()->role(), [Rule::SUPER_ADMIN, Rule::ADMIN])) {
                $sql .= " OR fee_detail.currency LIKE ? ";
                $sql .= " OR admin.firstname LIKE ? ";
                $sql .= " OR admin.lastname LIKE ? ";
                $sql .= " OR center.center_name LIKE ? ";
                $sql .= " OR fee_detail.student_id LIKE ?";

                $binds[] = '%' . $searchTerm . '%';
                $binds[] = '%' . $searchTerm . '%';
                $binds[] = '%' . $searchTerm . '%';
                $binds[] = '%' . $searchTerm . '%';
                $binds[] = '%' . $searchTerm . '%';
            }

            $sql .= " OR ( CASE WHEN 'verified' LIKE ? THEN verified = 1 ";
            $sql .= "      WHEN 'pending' LIKE ? THEN verified = 0 AND rejected = 0";
            $sql .= "      WHEN 'rejected' LIKE ? THEN rejected = 1 ";
            $sql .= " END ";
            $sql .= " ) ";
            $sql .= ") ";

            $binds = array_merge($binds, [
                '%' . strtolower($searchTerm) . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
            ]);
        }
        if (adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin()) {
            $sql .= ' AND fee_detail.fee_added_by_center =  ';
            $sql .= adminUser()->center_id ? adminUser()->center_id : 0;
        }

        $sql .= " AND fee_detail.deleted_at IS NULL";

        return DB::select($sql, $binds);
    }

    public function nonPaidList()
    {
        $selects = [
            'member.*',
            'pro_mem.created_at as joined_date'
        ];
        $sql  = " SELECT ";
        $sql .= implode(', ', $selects);
        $sql .= " FROM ";
        $sql .= " members member";
        $sql .= " JOIN program_students pro_mem ";
        $sql .= " ON pro_mem.student_id = member.id";
        $sql .= " LEFT JOIN program_student_fees pro_fees ";
        $sql .= " ON pro_fees.student_id = member.id";
        $sql .= " AND pro_fees.program_id = pro_mem.program_id ";
        $sql .= " AND pro_fees.deleted_at IS NULL ";
        $sql .= " WHERE ";
        $sql .= " pro_mem.program_id = ? ";
        $sql .= " AND ( pro_fees.student_id  IS NULL ";
        $sql .= " OR pro_fees.total_amount <= 0 ) ";

        return DB::select($sql, [$this->getKey()]);
    }
}
