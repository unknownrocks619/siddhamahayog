<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Live extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        "merge" => "object"
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'admin_start_url',
        'program_id'
    ];

    public function zoomAccount()
    {
        return $this->belongsTo(ZoomAccount::class, "zoom_account_id");
    }

    public function sections()
    {
        return $this->belongsTo(ProgramSection::class, "section_id");
    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }

    public function programSection()
    {
        return $this->belongsTo(ProgramSection::class, 'section_id');
    }

    public function programCordinate()
    {
        return $this->belongsTo(Member::class,'started_by');
        // return $this->guessBelongsToRelation(Member::class, "started_by");
    }

    public function attendances()
    {
        return $this->hasMany(ProgramStudentAttendance::class, 'meeting_id', 'meeting_id');
    }
}
