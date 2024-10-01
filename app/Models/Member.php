<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable, SoftDeletes;

    protected $casts = [
        "profileUrl" => "object",
        "address" => "object",
        "created_at" => "datetime",
        "profile" => "object",
        "remarks" => "object",
        'allow_username_login'  => 'bool'
        //        'member_uuid'   => 'uuid'
    ];

    protected $fillable = [
        "member_uuid",
        "full_name",
        "first_name",
        "middle_name",
        "last_name",
        "country",
        'city',
        'address',
        'date_of_birth',
        'email',
        'username',
        'allow_username_login',
        'remember_token',
        'sharing_code',
        'phone_number',
        'profile',
        'gender',
        'street_address',
        'gotra',
        'role_id',
        'source',
        'password',
        'created_at'
    ];

    protected $hidden = [
        'stripe_id',
        'pm_last_four',
        'trial_ends_at',
        'password',
        'created_at',
        'updated_at',
        'pm_type',
        'remember_token'
    ];

    const IMAGE_TYPES = [
        'profile_picture'   => 'Profile Picture',
        'id_card'           => 'ID Card',
        'event_gallery'     => "Event Pictures",
        'private'           => 'Private',
        'public'            => 'Public',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            if (! $model->member_uuid) {
                $model->member_uuid = Str::uuid();
            }
        });
    }

    public function diskshya()
    {
        return $this->hasMany(MemberDikshya::class);
    }
    public function member_role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function section()
    {
        return $this->hasOne(ProgramStudent::class, "student_id");
    }

    public function meta()
    {
        return $this->hasOne(MemberInfo::class, "member_id");
    }

    public function emergency()
    {
        return $this->hasOne(MemberEmergencyMeta::class, 'member_id')->latest();
    }

    public function emergency_contact()
    {
        return $this->hasMany(MemberEmergencyMeta::class, "member_id");
    }

    public function member_detail()
    {
        return $this->hasMany(ProgramStudent::class, "student_id");
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, "country");
    }


    public function cities()
    {
        return $this->belongsTo(City::class, "city");
    }

    public function refered()
    {
        return $this->hasMany(Reference::class, "referenced_by");
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'member_id');
    }

    public function transactions()
    {
        $transactions =  $this->hasMany(ProgramStudentFeeDetail::class, 'student_id');

        if (auth('admin')->check() && ! in_array(adminUser()->role(), [Rule::ADMIN, Rule::SUPER_ADMIN])) {

            $transactions->where('fee_added_by_center', adminUser()->center_id);
        }

        return $transactions;
    }

    public function studentFeeOverview()
    {
        return $this->hasOne(ProgramStudentFee::class, "student_id", 'id');
    }

    /**
     * @info List all members in datatable.
     */
    public static function all_members($searchTerm = null)
    {
        $binds = [];
        $sql = "SELECT member.id as member_id,
                        member.full_name,
                        member.email,
                        member.phone_number,

                        member.created_at,
                        country.name as country_name,
                        GROUP_CONCAT(program.program_name SEPARATOR ', ') AS 'program'
                FROM members member ";

        if (adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin()) {

            $sql .= " JOIN center_members cen_mem ";
            $sql .= " ON cen_mem.member_id = member.id ";
            $sql .= " AND cen_mem.center_id = " . adminUser()->center_id;
        }

        $sql .= " LEFT JOIN countries country
                        ON country.id = member.country

                    LEFT JOIN program_students pstd
                        ON pstd.student_id = member.id

                    LEFT JOIN programs program
                        ON program.id = pstd.program_id
                WHERE pstd.deleted_at IS NULL ";
        if (! empty($searchTerm)) {

            $sql .= " AND ( ";
            $sql .= " member.full_name LIKE ?";
            $sql .= " OR member.email LIKE ?";
            $sql .= " OR member.phone_number LIKE ?";
            $sql .= " ) ";
            $binds = [
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
                '%' . $searchTerm . '%',
            ];
        }

        $sql .= " AND member.deleted_at IS NULL
                                GROUP BY member.id";
        return DB::select($sql, $binds);
    }

    /**
     * Get Full name from member
     */
    public function full_name(): string
    {


        $full_name = ucwords($this->first_name);

        if ($this->middle_name) {
            $full_name .= ' ' . $this->middle_name;
        }

        $full_name .= ' ' . $this->last_name;

        return $full_name;
    }

    protected function Email(): Attribute
    {
        return Attribute::make(
            get: fn(string|null $value) => str($value ?? '')->contains('random_email_') ? '' : $value,
        );
    }
    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function profileImage(): HasOneThrough
    {

        return $this->hasOneThrough(Images::class, ImageRelation::class, 'relation_id', 'id', 'id', 'image_id')
            ->where('relation', self::class)
            ->where('type', 'profile_picture')
            ->latest();
    }

    /**
     * @return HasOneThrough
     */
    public function memberIDMedia(): HasOneThrough
    {
        return $this->hasOneThrough(Images::class, ImageRelation::class, 'relation_id', 'id', 'id', 'image_id')
            ->where('relation', self::class)
            ->where('type', 'id_card')
            ->latest();
    }

    public function media()
    {
        return $this->hasMany(ImageRelation::class, 'relation_id')
            ->where('relation', self::class);
    }
}
