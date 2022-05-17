<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramBatch extends Model
{
    use HasFactory;

    public function batch() {
        return $this->belongsTo(Batch::class,"batch_id");
    }
}
