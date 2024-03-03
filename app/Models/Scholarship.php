<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scholarship extends Model
{
    use HasFactory, SoftDeletes;

    const TYPES = [
        'vip'   => 'VIP',
        'full'  => 'Full',
        'void'  => 'Void'
    ];

    protected  $fillable = [
      'program_id',
      'student_id',
      'scholar_type',
      'active',
      'remarks'
    ];

    public static function studentByProgram(Program $program)
    {
        $query = self::where('program_id', $program->getKey())
            ->with(['students'])
            ->get();

        return $query;
    }

    public function students()
    {
        return $this->belongsTo(Member::class, 'student_id');
    }

    public static function boot()
    {
        parent::boot();

        return static::creating(function ($item) {
            return $item['created_by_user'] = auth()->id();
        });
    }
}
