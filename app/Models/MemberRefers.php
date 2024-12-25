<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberRefers
 *
 * @property int $id
 * @property int $member_id
 * @property string $full_name
 * @property string $phone_number
 * @property string|null $relation
 * @property string|null $country
 * @property string|null $email_address
 * @property string|null $remarks
 * @property string $status available option: pending, follow-ups,cancelled,approved
 * @property int|null $converted_id
 * @property string|null $approved_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereConvertedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereEmailAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberRefers withoutTrashed()
 * @mixin \Eloquent
 */
class MemberRefers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'full_name',
        'phone_number',
        'relation',
        'country',
        'email_address',
        'remarks',
        'status',
        'converted_id',
        'approved_date'
    ];

    const STATUS_OPTION = [
        'pending'   => "Pending",
        'follow-up' => 'Processing',
        'cancelled' => 'Cancelled',
        'approved'  => 'Approved'
    ];

    const STATUS_DISPLAY = [
      'pending' => '<span class="badge bg-label-primary">Pending</span>',
      'follow-up'   => "<span class='badge bg-label-info'>Processing</span>",
      'cancelled'   => '<span class="badge bg-label-danger">Cancelled</span>',
      'approved'  => '<span class="badge bg-label-success">Approved</span>'
    ];
}
