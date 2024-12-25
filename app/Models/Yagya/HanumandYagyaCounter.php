<?php

namespace App\Models\Yagya;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Yagya\HanumandYagyaCounter
 *
 * @property int $id
 * @property int $member_id
 * @property int|null $program_id
 * @property int $total_counter
 * @property int $is_taking_part
 * @property string|null $start_date
 * @property string $jap_type Available Option: Sumeru, Mala, Mantra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Yagya\HanumandDailyCounter> $dailyCounter
 * @property-read int|null $daily_counter_count
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter query()
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereIsTakingPart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereJapType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereTotalCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HanumandYagyaCounter whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HanumandYagyaCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'program_id',
        'total_counter',
        'start_date',
        'jap_type',
        'is_taking_part'
    ];

    public function dailyCounter() {
        return $this->hasMany(HanumandDailyCounter::class,'humand_yagya_id','id');
    }

}
