<?php

namespace App\Models\Yagya;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HanumandYagyaCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'program_id',
        'total_counter',
        'start_date',
        'jap_type',
        'is_taking_part'
    ];

    public function dailyCounter() {
        return $this->hasMany(HanumandDailyCounter::class,'humand_yagya_id','id');
    }

}
