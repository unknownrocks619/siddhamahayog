<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberInfo
 *
 * @property int $id
 * @property int $member_id
 * @property object|null $history
 * @property object|null $personal
 * @property object $education
 * @property object|null $remarks
 * @property string $total_connected_family
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo wherePersonal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereTotalConnectedFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberInfo withoutTrashed()
 * @mixin \Eloquent
 */
class MemberInfo extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "history" => "object",
        "education" => "object",
        "personal" => "object",
        'remarks' => 'object'
    ];

    protected $fillable = [
        'education',
        'history',
        'member_id',
        'history',
        'personal'
    ];
}
