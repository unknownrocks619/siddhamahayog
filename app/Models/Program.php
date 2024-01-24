<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Program extends Model
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
        'program_type'
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
        Role::SUPER_ADMIN,
        Role::ADMIN
    ];

    public const EDIT_PROGRAM_ACCESS = [
        Role::SUPER_ADMIN,
        Role::ADMIN
    ];

    public const STUDENT_COUNT_ACCESS = [
        Role::SUPER_ADMIN,
        Role::ADMIN
    ];

    public const QUICK_NAVIGATION_ACCESS = [
        'syllabus_and_resources'    => [
            'label' => 'Syllabus / Resources',
            'access'    => [Role::SUPER_ADMIN,Role::ACTING_ADMIN,Role::ADMIN]
        ],
        'program_daily_attendance'  => [
            'label' => 'Program Daily Attendance',
            'access'    => [Role::SUPER_ADMIN,Role::ADMIN]
        ],
        'account_and_management' => [
            'label' => 'Account Management',
            'access'    => [Role::SUPER_ADMIN]
        ],

        'assign_member_to_program'  => [
            'label' => 'Assign Member to Program',
            'access'    => [Role::SUPER_ADMIN,Role::ADMIN]
        ],
        'register_new_member_to_program'    => [
            'label' => 'Register Member',
            'access'    => [Role::SUPER_ADMIN,Role::ADMIN]
        ],
        'scholarship_and_special_permission' => [
            'label' => 'Scholarship & Special Permission',
            'access'    => [Role::SUPER_ADMIN,Role::ADMIN]
        ],
        'vip_and_guest_list'    => [
            'label' => 'VIP / Guest Access List',
            'access'    => [Role::SUPER_ADMIN,Role::ADMIN]
        ],
        'grouping'  => [
            'label' => 'Group',
            'access'    => [Role::SUPER_ADMIN]
        ]
    ];

    public function students()
    {
        return $this->hasMany(ProgramStudent::class, $this->foreignKey);
    }

    public function program_active_student()
    {
        return $this->hasOne(ProgramStudent::class, $this->foreignKey)->where('student_id', user()->getKey())->where('active', true)->first();
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

    public function defaultBatch() {
        return $this->hasOne(Batch::class,'id','batch');
    }

    public function programStudentEnrolments($searchTerm = null) {
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

        if ( $this->getKey() == 5 ) {
            $selects[] = 'yagya.total_counter';
        }

        $sql = "SELECT ";
        $sql .= implode(', ', $selects);
        $sql .= ' FROM programs pro';

        $sql .= ' INNER JOIN program_students prostu';
        $sql .= ' ON prostu.program_id = pro.id';
        $sql .= ' AND prostu.deleted_at IS NULL';

        $sql .=' INNER JOIN members member';
        $sql .= ' ON member.id = prostu.student_id';
        $sql .= " AND member.deleted_at IS NULL";

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

        if ( $this->getKey() == 5 ) {
            $sql .= " LEFT JOIN hanumand_yagya_counters yagya";
            $sql .= " ON yagya.member_id = member.id";
            $sql .= " AND yagya.program_id = pro.id ";
        }

        $sql .= " WHERE pro.id = ?";

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

    public function totalAdmissionFee() {
        $sql = " SELECT SUM(amount) as total_amount, ";
        $sql .= "  COALESCE(amount_category, 'grand_total') AS total_by";
        $sql .= " FROM program_student_fee_details prostufee";
        $sql .= " WHERE prostufee.verified  = 1";
        $sql .= " AND prostufee.program_id = ?";
        $sql .=  " GROUP BY prostufee.amount_category";
        $sql .= " WITH ROLLUP";

        return DB::select($sql, [$this->getKey()]);
    }

    public function programBatches() {
        return $this->hasManyThrough(Batch::class,ProgramBatch::class,'program_id','id','id','batch_id');
    }

    public function totalRevenue() {

    }


    public function transactionOverview($term = null) {
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
        $sql .= implode (" , ", $selects);
        $sql .= " FROM  program_student_fees fees";
        $sql .= " JOIN members member ";
        $sql .= " ON member.id = fees.student_id";
        $sql .= ' AND member.deleted_at IS NULL ';
        $sql .= " WHERE fees.program_id = ?";
        $sql .= " AND fees.deleted_at IS NULL ";

        if ( $term ) {
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

            $binds = array_merge($binds,['%'.$term.'%',
                    '%'.$term.'%',
                    '%'.$term.'%',
                    '%'.$term.'%',
                    $term]
            );
        }

        return DB::select($sql,$binds);
    }
    public function transactionsDetail($searchTerm = null) {
        $selects = [
            'fee_detail.id as transaction_id',
            'fee_detail.program_student_fees_id as transaction_overview_id',
            'fee_detail.amount',
            'fee_detail.amount_category',
            'fee_detail.source',
            'fee_detail.source_detail',
            'fee_detail.verified',
            'fee_detail.rejected',
            'fee_detail.remarks',
            'fee_detail.file',
            'fee_detail.created_at as transaction_date',
            'member.full_name',
            'member.email',
            'member.phone_number',
            'member.id as member_id'
        ];
        $binds = [$this->getKey()];

        $sql = " SELECT ";
        $sql .= implode(' , ', $selects);
        $sql .= " FROM program_student_fee_details fee_detail";

        $sql .= " JOIN members member";
        $sql .= " ON member.id = fee_detail.student_id";

        $sql .= " WHERE fee_detail.program_id = ? ";

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
                $sql .= " OR ( CASE WHEN 'verified' LIKE ? THEN verified = 1 ";
                $sql .= "      WHEN 'pending' LIKE ? THEN verified = 0 AND rejected = 0";
                $sql .= "      WHEN 'rejected' LIKE ? THEN rejected = 1 ";
                $sql .= " END ";
                $sql .= " ) ";
            $sql .= ") ";

            $binds = array_merge ($binds, [
                '%'.strtolower($searchTerm).'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
            ]);
        }

        $sql .= " AND fee_detail.deleted_at IS NULL";

        return DB::select($sql,$binds);
    }

    public function nonPaidList(){
        $selects = [
            'member.*',
            'pro_mem.created_at as joined_date'
        ];
        $sql  = " SELECT ";
        $sql .= implode (', ', $selects);
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

        return DB::select($sql,[$this->getKey()]);
    }
}
