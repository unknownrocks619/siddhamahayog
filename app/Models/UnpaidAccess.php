<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnpaidAccess extends Model
{
    use HasFactory;

    public static function totalAccess(Member $member, Program $program)
    {

        $getRow = self::where('program_id', $program->getKey())->where('member_id', $member->getKey())
            ->first();
        if ($getRow) {
            return $getRow->total_joined;
        }
        return 1;
    }
}
