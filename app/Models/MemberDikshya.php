<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberDikshya
 *
 * @property int $id
 * @property int $member_id
 * @property string $rashi_name
 * @property string|null $guru_name
 * @property string $dikshya_type
 * @property string $ceromony_location
 * @property string|null $ceromony_date
 * @property array|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereCeromonyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereCeromonyLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereDikshyaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereGuruName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereRashiName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MemberDikshya whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberDikshya extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'remarks',
        'dikshya_type',
        'rashi_name',
        'ceromony_location',
        'ceromony_date',
        'guru_name'
    ];

    protected $casts = [
        'remarks' => 'array'
    ];
}
