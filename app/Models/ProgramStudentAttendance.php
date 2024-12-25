<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramStudentAttendance
 *
 * @property int $id
 * @property int $program_id
 * @property int $student
 * @property int $section_id
 * @property int $live_id
 * @property string|null $meeting_id
 * @property int|null $attendance_date_id
 * @property int $active
 * @property string $join_url
 * @property object $meta
 * @property-read \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereAttendanceDateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereJoinUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereLiveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereStudent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentAttendance withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramStudentAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "meta" => "object",
    ];


    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
        );
    }
}
