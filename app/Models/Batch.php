<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'batch_name',
        'slug',
        'batch_year',
        'batch_month'
    ];

    use HasFactory;

    public function batch_program() {
        return $this->hasMany(ProgramBatch::class,"batch_id");
    }
}
