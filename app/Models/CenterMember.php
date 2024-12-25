<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CenterMember
 *
 * @property int $id
 * @property int $member_id
 * @property int $center_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember whereCenterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CenterMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CenterMember extends Model
{
    protected $fillable = [
        'member_id',
        'center_id'
    ];

    
}
