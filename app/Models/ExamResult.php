<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamResult extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'program_exam_id',
        'total_marks',
        'obtained_marks',
        'total_right',
        'total_wrong',
        'full_name',
        'address',
        'created_at',
        'updated_at'
    ];
}
