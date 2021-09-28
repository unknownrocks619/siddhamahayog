<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class userReference extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'center_id',
        'user_detail_id',
        'name',
        'phone_number',
        'created_by_user',
        'user_referer_id'
    ];

    public function userdetail(){
        return $this->belongsTo(userDetail::class);
    }

    public function branches(){
        return $this->belongsTo(Center::class,'center_id');
    }
}
