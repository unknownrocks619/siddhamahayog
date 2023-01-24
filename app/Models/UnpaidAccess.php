<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnpaidAccess extends Model
{
    use HasFactory, SoftDeletes;

    public static function totalAccess(Member $member, Program $program)
    {

        $getRow = self::where('program_id', $program->getKey())->where('member_id', $member->getKey())
            ->first();
        if ($getRow) {
            return $getRow->total_joined;
        }
        return 1;
    }

    public function student()
    {
        return $this->belongsTo(Member::class, "member_id");
    }
}
