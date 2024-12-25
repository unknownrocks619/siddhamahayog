<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramVolunteerAvailableDates
 *
 * @property int $id
 * @property int|null $member_id
 * @property int $program_volunteer_id
 * @property string $available_dates
 * @property string $status
 * @property string|null $remarks
 * @property string|null $reporting_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereAvailableDates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereProgramVolunteerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereReportingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramVolunteerAvailableDates withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramVolunteerAvailableDates extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'member_id',
        'program_volunteer_id',
        'available_dates',
        'status',
    ];
}
