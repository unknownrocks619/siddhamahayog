<?php

namespace App\Models;

use App\Models\Dharmasala\DharmasalaBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramGroupPeople
 *
 * @property int $id
 * @property int $member_id
 * @property int $program_id
 * @property int $group_id
 * @property int|null $transaction_id
 * @property string|null $full_name
 * @property string|null $phone_number
 * @property string|null $email
 * @property string|null $address
 * @property int|null $profile_id
 * @property string|null $member_id_card
 * @property int $verified
 * @property int|null $is_parent
 * @property int|null $id_parent
 * @property string|null $parent_relation
 * @property string|null $dharmasala_booking_id
 * @property string|null $dharmasala-uuid
 * @property string|null $access_permission
 * @property int|null $order
 * @property string $colour
 * @property string|null $group_uuid
 * @property int $is_card_generated
 * @property string|null $generated_id_card
 * @property string|null $resized_image
 * @property string|null $barcode_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $total_scanned
 * @property-read \App\Models\Images|null $IDCard
 * @property-read DharmasalaBooking|null $dharmasala
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ProgramGroupPeople> $families
 * @property-read int|null $families_count
 * @property-read \App\Models\ProgramGrouping|null $group
 * @property-read ProgramGroupPeople|null $parentFamily
 * @property-read \App\Models\Images|null $profile
 * @property-read \App\Models\Program|null $program
 * @property-read \App\Models\ProgramGrouping|null $programGroup
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereAccessPermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereBarcodeImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereDharmasalaBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereDharmasalaUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereGeneratedIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereGroupUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereIsCardGenerated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereIsParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereMemberIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereParentRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereProfileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereResizedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereTotalScanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramGroupPeople withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramGroupPeople extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'full_name',
        'phone_number',
        'address',
        'email',
        'group_uuid',
        'is_card_generated',
        'generated_id_card',
        'profile_id',
        'member_id_card',
        'member_id',
        'program_id',
        'group_id',
        'is_parent',
        'id_parent',
        'parent_relation',
        'dharmasala_booking_id',
        'dharmasala_uuid',
        'access_permission',
        'order',
        'colour'
    ];

    public function families() {
        return $this->hasMany(ProgramGroupPeople::class,'id_parent','id');
    }

    public function parentFamily() {
        return $this->belongsTo(ProgramGroupPeople::class,'id_parent','id');
    }

    public function group() {
        return $this->belongsTo(ProgramGrouping::class,'group_id');
    }

    public function profile() {
        return $this->belongsTo(Images::class,'profile_id');
    }

    public function IDCard() {
        return $this->belongsTo(Images::class,'member_id_card');
    }

    public function programGroup() {
        return $this->belongsTo(ProgramGrouping::class,'group_id');
    }

    public function dharmasala() {
        return $this->belongsTo(DharmasalaBooking::class,'dharmasala_booking_id');
    }

    public function program() {
        return $this->belongsTo(Program::class,'program_id');
    }
}
