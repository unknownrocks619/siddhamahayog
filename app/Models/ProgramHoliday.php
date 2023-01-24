<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramHoliday extends Model
{
    use HasFactory, SoftDeletes;

    public function student()
    {
        return $this->belongsTo(Member::class, "student_id");
    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }
}
