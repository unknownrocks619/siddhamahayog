<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Scholarship
 *
 * @property int $id
 * @property int $student_id
 * @property int $program_id
 * @property string $scholar_type Full, Half, Void, VIP
 * @property string|null $remarks
 * @property string|null $documents
 * @property int $active
 * @property string|null $created_by_user
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Member $students
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship query()
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereCreatedByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereScholarType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Scholarship withoutTrashed()
 * @mixin \Eloquent
 */
class Scholarship extends Model
{
    use HasFactory, SoftDeletes;

    const TYPES = [
        'vip'   => 'VIP',
        'full'  => 'Full',
        'void'  => 'Void'
    ];

    protected  $fillable = [
      'program_id',
      'student_id',
      'scholar_type',
      'active',
      'remarks'
    ];

    public static function studentByProgram(Program $program)
    {
        $query = self::where('program_id', $program->getKey())
            ->with(['students'])
            ->get();

        return $query;
    }

    public function students()
    {
        return $this->belongsTo(Member::class, 'student_id');
    }

    public static function boot()
    {
        parent::boot();

        return static::creating(function ($item) {
            return $item['created_by_user'] = auth()->id();
        });
    }
}
