<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramChapterLession
 *
 * @property int $id
 * @property string $program_course_id
 * @property string $program_id
 * @property string $lession_name
 * @property string|null $slug
 * @property string|null $total_duration
 * @property string|null $total_credit
 * @property string $lession_output
 * @property string $online_medium
 * @property string|null $video_total_duration
 * @property string|null $lession_date
 * @property string $video_lock
 * @property string|null $lock_after No of days, with respect to created at or lession_date
 * @property string|null $video_description
 * @property string $status Current Lession status.
 * @property string|null $sort
 * @property string|null $video_link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ProgramCourse|null $course
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereLessionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereLessionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereLessionOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereLockAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereOnlineMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereProgramCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereTotalCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereTotalDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereVideoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereVideoLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereVideoLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession whereVideoTotalDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramChapterLession withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramChapterLession extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'program_course_id',
        'program_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'video_link',
        
    ];

    protected $alias = [
        'lession_name' => 'name'
    ];

    public function course()
    {
        return $this->belongsTo(ProgramCourse::class, "program_course_id");
    }
}
