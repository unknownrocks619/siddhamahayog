<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProgramStudentEnroll
 *
 * @property int $id
 * @property string $program_id
 * @property string $member_id
 * @property string $enroll_date
 * @property string $program_course_fee_id
 * @property int $scholarship
 * @property string|null $scholarship_document
 * @property string|null $scholarship_cause
 * @property string $scholarship_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereEnrollDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereProgramCourseFeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereScholarship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereScholarshipCause($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereScholarshipDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereScholarshipType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramStudentEnroll withoutTrashed()
 * @mixin \Eloquent
 */
class ProgramStudentEnroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'member_id',
        'enrolled_date',
        'program_course_fee_id',
        'scholarship',
        'scholarship_documents',
        'scholarship_cause',
        'scholarship_type'
    ];
}
