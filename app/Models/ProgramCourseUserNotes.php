<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProgramCourseUserNotes
 *
 * @property int $id
 * @property string $program_id
 * @property string $program_course_id
 * @property string|null $program_chapter_lession_id
 * @property string|null $note
 * @property string $type available options draft.
 * @property string $access available options: private, public
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereProgramChapterLessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereProgramCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseUserNotes whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProgramCourseUserNotes extends Model
{
    use HasFactory;
}
