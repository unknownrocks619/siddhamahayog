<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageRelation extends Model
{
    use HasFactory,SoftDeletes;

    protected  $fillable = [
        'image_id',
        'relation_id',
        'relation',
        'type',
        'title',
        'description'
    ];

    protected $with = [
        'image'
    ];

    public function image() {
        return $this->hasOne(Images::class,'id','image_id');
    }
}
