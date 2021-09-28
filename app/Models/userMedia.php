<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class userMedia extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "user_medias";
    
    protected $fillable = [
        'created_by_user',
        'user_detail_id',
        'image_property',
        'image_url',
        'active'
    ];
}
