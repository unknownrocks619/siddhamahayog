<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramCourse
 *
 * @property int $id
 * @property string $course_name
 * @property string $slug
 * @property string $program_id
 * @property string|null $total_chapters
 * @property int|null $enable_resource
 * @property string|null $description
 * @property int $public_visible
 * @property int $lock
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramChapterLession> $lession
 * @property-read int|null $lession_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProgramCourseResources> $resources
 * @property-read int|null $resources_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LessionWatchHistory> $videoWatchHistory
 * @property-read int|null $video_watch_history_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereEnableResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse wherePublicVisible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereTotalChapters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourse withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramCourse extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * List all video related to selected course id.
     */
    public function lession()
    {
        return $this->hasMany(ProgramChapterLession::class, "program_course_id");
    }

    /**
     * List all resource (except video) to selected course id.
     */
    public function resources()
    {
        return $this->hasMany(ProgramCourseResources::class, "program_course_id");
    }

    public function videoWatchHistory()
    {
        return $this->hasMany(LessionWatchHistory::class, "program_course_id");
    }
}
