<?php

namespace App\Models;

use App\Models\Dharmasala\DharmasalaBuildingRoom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DharmasalaAmenity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'amenity_name',
        'slug',
        'icon'
    ];

    public function rooms() {
        return DharmasalaBuildingRoom::
                    whereJsonContains('amenities',str($this->getKey())->toString())
                    ->get();
    }
}
