<?php

namespace App\Models\Yagya;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HanumandDailyCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'humand_yagya_id',
        'member_id',
        'count_date',
        'total_count',

    ];
}
