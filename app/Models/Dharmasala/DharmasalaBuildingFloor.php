<?php

namespace App\Models\Dharmasala;

use FontLib\Table\Type\post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DharmasalaBuildingFloor extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable = [
        'building_id',
        'floor_name',
        'total_rooms',
        'status',
        'online',
        'floor_prefix'
    ];

    protected  $with = [
      'rooms'
    ];
    public function rooms() {
        return $this->hasMany(DharmasalaBuildingRoom::class,'floor_id');
    }
}
