<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    use HasFactory;

    protected $casts = [
        "merge" => "object"
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
        return $this->guessBelongsToRelation(Member::class, "started_by");
    }
}
