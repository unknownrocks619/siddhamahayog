<?php

namespace App\Models;

use App\Models\Dharmasala\DharmasalaBuildingRoom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DharmasalaAmenity extends Model
{
    use HasFactory, SoftDeletes;

    public function rooms() {
        return $this->hasMany(DharmasalaBuildingRoom::class);
    }
}
