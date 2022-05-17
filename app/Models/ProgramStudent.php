<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudent extends Model
{
    use HasFactory;

    public function program() {
        return $this->belongsTo(Program::class,"program_id");
    }

    public function section() {
        return $this->belongsTo(ProgramSection::class,"program_section_id");
    }

    public function batch() {
        return $this->belongsTo(ProgramSection::class,"batch_id");
    }

    public function student() {
        return $this->belongsTo(Member::class,"student_id");
    }
}
