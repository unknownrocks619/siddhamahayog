<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramCourseResources
 *
 * @property int $id
 * @property string $program_id
 * @property string $program_course_id
 * @property string|null $resource_title
 * @property string|null $slug
 * @property string|null $resource_type text
 * @property string|null $description
 * @property object|null $resource
 * @property int $lock
 * @property int|null $lock_after no. of days after upload.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Program|null $program
 * @property-read \App\Models\ProgramCourse|null $program_course
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereLockAfter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereProgramCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereResourceTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereResourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramCourseResources withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramCourseResources extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "resource" => "object"
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    public function program_course()
    {
        return $this->belongsTo(ProgramCourse::class, "program_course_id");
    }
}
