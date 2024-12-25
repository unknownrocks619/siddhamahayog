<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ramdas
 *
 * @property int $id
 * @property int $member_id
 * @property string $role_id
 * @property string $meeting_id
 * @property string $full_name
 * @property string $reference_number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ramdas whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ramdas extends Model
{
    use HasFactory;
}
