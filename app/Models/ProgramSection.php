<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSection extends Model
{
    use HasFactory;

    protected  $fillable = [
        'program_id',
        'section_name',
        'slug',
        'default'
    ];

    public function programStudents()
    {
        return $this->hasMany(ProgramStudent::class, "program_section_id");
    }
}
