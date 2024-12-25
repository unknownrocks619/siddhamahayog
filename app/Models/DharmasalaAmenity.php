<?php

namespace App\Models;

use App\Models\Dharmasala\DharmasalaBuildingRoom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\DharmasalaAmenity
 *
 * @property int $id
 * @property string $amenity_name
 * @property string $slug
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity query()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity whereAmenityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DharmasalaAmenity withoutTrashed()
 * @mixin \Eloquent
 */
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
