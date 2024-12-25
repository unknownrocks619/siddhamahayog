<?php

namespace App\Models\Dharmasala;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Dharmasala\DharmasalaBuilding
 *
 * @property int $id
 * @property string $building_name
 * @property string $no_of_floors
 * @property string|null $building_location
 * @property string|null $building_color
 * @property string $building_category can be used to distinguished for VIP building
 * @property string $status
 * @property int $online
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dharmasala\DharmasalaBuildingFloor> $floors
 * @property-read int|null $floors_count
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding query()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereBuildingCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereBuildingColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereBuildingLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereBuildingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereNoOfFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuilding withoutTrashed()
 * @mixin \Eloquent
 */
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
