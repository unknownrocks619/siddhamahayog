<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProgramStudentFee extends Model
{
    use HasFactory, SoftDeletes;

    public function member()
    {
        return $this->belongsTo(Member::class, "student_id");
    }

    public function transactions()
    {
        return $this->hasMany(ProgramStudentFeeDetail::class, "program_student_fees_id");
    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

}
