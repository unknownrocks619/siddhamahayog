<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    public function section()
    {
        return $this->belongsTo(ProgramSection::class, "program_section_id");
    }

    public function batch()
    {
        return $this->belongsTo(ProgramBatch::class, "batch_id");
    }

    public function student()
    {
        return $this->belongsTo(Member::class, "student_id");
    }

    public function live()
    {
        return $this->belongsTo(Live::class, "program_id", "program_id")->where('live', true);
    }

    /**
     * @param int $programID
     * @param int $userID
     * @return bool
     */
    public static function studentExists(int $programID, int $userID): bool
    {

        return ProgramStudent::where('program_id', $programID)
            ->where('student_id', $userID)
            ->exists();
    }
}
