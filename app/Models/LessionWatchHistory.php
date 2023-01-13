<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessionWatchHistory extends Model
{
    use HasFactory, SoftDeletes;

    public function lession()
    {
        return $this->belongsTo(ProgramChapterLession::class, "program_chapter_lession_id")->latest();
    }

    public function program()
    {
        return $this->belongsTo(Program::class, "program_id");
    }
}
