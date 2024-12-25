<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UnpaidAccess
 *
 * @property int $id
 * @property int $member_id
 * @property string $program_id
 * @property int $total_joined
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Member $student
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess query()
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess whereTotalJoined($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UnpaidAccess withoutTrashed()
 * @mixin \Eloquent
 */
class UnpaidAccess extends Model
{
    use HasFactory, SoftDeletes;

    public static function totalAccess(Member $member, Program $program)
    {

        $getRow = self::where('program_id', $program->getKey())->where('member_id', $member->getKey())
            ->first();
        if ($getRow) {
            return $getRow->total_joined;
        }
        return 1;
    }

    public function student()
    {
        return $this->belongsTo(Member::class, "member_id");
    }
}
