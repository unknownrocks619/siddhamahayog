<?php

namespace App\Models\Yagya;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Yagya\HanumandDailyCounter
 *
 * @property int $id
 * @property int $humand_yagya_id
 * @property int $member_id
 * @property string $count_date
 * @property string $total_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter query()
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter whereCountDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter whereHumandYagyaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter whereTotalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandDailyCounter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HanumandDailyCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'humand_yagya_id',
        'member_id',
        'count_date',
        'total_count',

    ];
}
