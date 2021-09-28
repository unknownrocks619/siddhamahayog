<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SibirBranche extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sibir_record_id',
        'branch_id',
        'capacity',
        'active',
    ];

    public function branch() {
        return $this->belongsTo(Center::class);
    }

    public function sibir() {
        return $this->belongsTo(SibirRecord::class);
    }

}
