<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramBatch extends Model
{
    use HasFactory;

    protected $primaryKey='id';

    protected $table = 'program_batches';

    public $fillable = [
        "active",
        'program_id',
        'batch_id'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, "batch_id");
    }
}
