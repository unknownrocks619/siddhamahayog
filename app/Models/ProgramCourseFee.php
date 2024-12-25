<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramCourseFee
 *
 * @property int $id
 * @property string $program_id
 * @property string $admission_fee
 * @property string $monthly_fee
 * @property int $online
 * @property int $offline
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereAdmissionFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereMonthlyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereOffline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseFee withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramCourseFee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'admission_fee',
        'monthly_fee',
        'online',
        'offline',
        'active'
    ];
}
