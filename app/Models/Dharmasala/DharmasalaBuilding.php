<?php

namespace App\Models\Dharmasala;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DharmasalaBuilding extends Model
{
    use HasFactory,SoftDeletes;

    protected  $fillable = [
        'building_name',
        'no_of_floors',
        'building_location',
        'building_color',
        'building_category',
        'status',
        'online',
    ];

    public const BuildingCategory = [
        'general'   => 'General',
        'vip'       => 'VIP',
        'paid'      => 'Paid',
        'reserved'  => 'Reserved'
    ];
    /**
     * return all floors for selected building
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function floors() {
        return $this->hasMany(DharmasalaBuildingFloor::class,'building_id');
    }

}
