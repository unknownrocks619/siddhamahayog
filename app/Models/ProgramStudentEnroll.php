<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
