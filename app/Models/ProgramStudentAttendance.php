<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudentAttendance extends Model
{
    use HasFactory;

    protected $casts = [
        "meta" => "object"
    ];
}
