<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Night extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_detail_id',
        'nights'
    ];

    public function userdetail(){
        return $this->belongsTo(userDetail::class,'user_detail_id');
    }
}
