<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramHoliday
 *
 * @property int $id
 * @property int $program_id
 * @property int $student_id
 * @property string|null $subject
 * @property string $reason
 * @property string $start_date
 * @property string $end_date
 * @property string $status Available Options: pending, approved, rejected.
 * @property string|null $response_text
 * @property string|null $response_date
 * @property int|null $response_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Program $program
 * @property-read \App\Models\Member $student
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereResponseBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereResponseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereResponseText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramHoliday withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramHoliday extends Model
{
    use HasFactory, SoftDeletes;

    public function student()
    {
        return $this->belongsTo(Member::class, "student_id");
    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }
}
