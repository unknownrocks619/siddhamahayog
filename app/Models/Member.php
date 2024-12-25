<?php

namespace App\Models;

use App\Classes\Helpers\Roles\Rule;
use App\Classes\Helpers\UserHelper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Member
 *
 * @property int $id
 * @property string|null $member_uuid
 * @property string $full_name
 * @property string $first_name
 * @property string|null $middle_name
 * @property string|null $last_name
 * @property string|null $gotra
 * @property string $source available options: facebook, gmail
 * @property string|null $external_source_id If login using facebook and gmail use this to track their id.
 * @property object|null $profile
 * @property string|null $gender
 * @property int|null $country
 * @property string|null $city
 * @property object|null $address
 * @property string|null $date_of_birth
 * @property string|null $birth_time
 * @property-read string|null $email
 * @property string|null $username
 * @property bool $allow_username_login
 * @property string $password
 * @property string|null $phone_number
 * @property string|null $father_name
 * @property string|null $mother_name
 * @property object|null $profileUrl for social media login
 * @property int $is_email_verified
 * @property int $is_phone_verified
 * @property string $role_id
 * @property string|null $id_card
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $remember_token
 * @property string|null $sharing_code
 * @property string|null $permalink
 * @property object|null $remarks
 * @property string|null $student_rollnumber
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \App\Models\City|null $cities
 * @property-read \App\Models\Country|null $countries
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MemberDikshya> $diskshya
 * @property-read int|null $diskshya_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Donation> $donations
 * @property-read int|null $donations_count
 * @property-read \App\Models\MemberEmergencyMeta|null $emergency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MemberEmergencyMeta> $emergency_contact
 * @property-read int|null $emergency_contact_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ImageRelation> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Images|null $memberIDMedia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramStudent> $member_detail
 * @property-read int|null $member_detail_count
 * @property-read \App\Models\Role|null $member_role
 * @property-read \App\Models\MemberInfo|null $meta
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Images|null $profileImage
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reference> $refered
 * @property-read int|null $refered_count
 * @property-read \App\Models\ProgramStudent|null $section
 * @property-read \App\Models\ProgramStudentFee|null $studentFeeOverview
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramStudentFeeDetail> $transactions
 * @property-read int|null $transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereAllowUsernameLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereBirthTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereExternalSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereGotra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereIsEmailVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereIsPhoneVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMemberUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereMotherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePermalink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereProfileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereSharingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereStudentRollnumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Member withoutTrashed()
 * @mixin \Eloquent
 */
class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable, SoftDeletes, UserHelper;

    const LOGIN_TYPE = [
        0 => 'email',
        1 => 'username',
        2 => 'phone', /// For the moment, only allow login if the user was registred using mobile. // also make sure phone number is verified.
        3 => '*',
        4 => 'password less',
    ];

    const LOGIN_TYPE_EMAIL = 0;
    const LOGIN_TYPE_USERNAME = 1;
    const LOGIN_TYPE_PHONE = 2;
    const LOGIN_TYPE_ALL = 3;
    const LOGIN_TYPE_PASSWORDLESS = 4; // only allowed for country Nepal

    protected static Rule|null $rule;

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

    public static function mobile_users($searchTerm = null)
    {
        $binds = [];
        $member = Member::query();
        $member->select(['member.id as member_id', 'member.full_name', 'member.email', 'member.phone_number', 'mobile.created_at', 'country.name as country_name']);
        $member->from('members as member');
        $member->join('personal_access_tokens', function (JoinClause $join) {
            $join->on('tokenable_id', '=', 'member_id');
            $join->on('tokenable_type', 'App\\Models\\Member');
        });

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


        $this->full_name = $full_name;
        $this->save();

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
     * @return HasOneThrough
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

    public function role(): Rule|null
    {
        self::$rule = Rule::tryFrom(user()->role_id);
        return self::$rule?->role();
    }

    public function myMembers()
    {
        return $this->hasManyThrough(Member::class, MemberUnderLink::class, 'teacher_id', 'id', 'id', 'student_id');
    }

    public function mySession()
    {
        return $this->hasMany(UserTrainingCourse::class, 'id_user')
            ->with('enrolledUsers');
    }
}
