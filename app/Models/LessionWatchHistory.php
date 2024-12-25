<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\LessionWatchHistory
 *
 * @property int $id
 * @property int $student_id
 * @property int $program_id
 * @property int $program_course_id
 * @property int $program_chapter_lession_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ProgramChapterLession $lession
 * @property-read \App\Models\Program $program
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereProgramChapterLessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereProgramCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionWatchHistory withoutTrashed()
 * @mixin \Eloquent
 */
class LessionWatchHistory extends Model
{
    use HasFactory, SoftDeletes;

    public function lession()
    {
        return $this->belongsTo(ProgramChapterLession::class, "program_chapter_lession_id")->latest();
    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }
}
