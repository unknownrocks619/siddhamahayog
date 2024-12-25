<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EsewaPreProcess
 *
 * @property int $id
 * @property int $member_id
 * @property string $pid
 * @property string $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess query()
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EsewaPreProcess whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EsewaPreProcess extends Model
{
    use HasFactory;
}
