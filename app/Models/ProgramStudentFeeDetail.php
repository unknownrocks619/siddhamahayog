<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudentFeeDetail extends Model
{
    use HasFactory,SoftDeletes;

    public function student_fee(){
        return $this->belongsTo(ProgramStudentFee::class,"program_student_fees_id");
    }

    public function student(){
        return $this->belongsTo(Member::class,"student_id");
    }

    public function program()
    {
        return $this->belongsTo(Program::class,"program_id");
    }
}
