<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProgramExam
 *
 * @property int $id
 * @property string $program_id
 * @property string $title
 * @property int $enable_time
 * @property int $active
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $description
 * @property string|null $full_marks
 * @property string|null $pass_marks
 * @property string|null $total_questions
 * @property string|null $question_by_category
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereEnableTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereFullMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam wherePassMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereQuestionByCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereTotalQuestions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProgramExam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProgramExam extends Model
{
    use HasFactory;
}
