<?php

namespace App\Models\Dharmasala;

use FontLib\Table\Type\post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Dharmasala\DharmasalaBuildingFloor
 *
 * @property int $id
 * @property int $building_id
 * @property string $floor_name
 * @property string|null $floor_prefix
 * @property string|null $total_rooms
 * @property string $status
 * @property int $online
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dharmasala\DharmasalaBuildingRoom> $rooms
 * @property-read int|null $rooms_count
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor query()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereBuildingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereFloorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereFloorPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereTotalRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaBuildingFloor withoutTrashed()
 * @mixin \Eloquent
 */
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
