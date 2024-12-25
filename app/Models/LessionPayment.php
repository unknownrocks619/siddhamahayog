<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LessionPayment
 *
 * @property int $id
 * @property int $program_chapter_lession_id
 * @property int $student_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment whereProgramChapterLessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LessionPayment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LessionPayment extends Model
{
    use HasFactory;
}
