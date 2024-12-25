<?php

namespace App\Models\Sadhak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sadhak\MemberToSadhak
 *
 * @property int $id
 * @property int $member_id
 * @property string $join_link
 * @property object|null $joinHistory
 * @property string $join_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereJoinHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereJoinLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereJoinType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberToSadhak whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberToSadhak extends Model
{
    use HasFactory;

    protected $casts = [
        'joinHistory' => "object"
    ];
}
