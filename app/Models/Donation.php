<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Donation
 *
 * @property int $id
 * @property int $member_id
 * @property string $amount
 * @property int $verified
 * @property object|null $remarks
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Donation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Donation withoutTrashed()
 * @mixin \Eloquent
 */
class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "verified",
        "remarks",
        "type",
        'member_id',
        'amount'
    ];

    protected $hidden = [
        "member_id",
        "amount"
    ];

    protected $casts = [
        "remarks" => "object"
    ];
}
