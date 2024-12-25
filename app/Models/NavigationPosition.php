<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\NavigationPosition
 *
 * @property int $id
 * @property string $nav_position
 * @property array|null $permission
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NavigationItem> $navigationItems
 * @property-read int|null $navigation_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition whereNavPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NavigationPosition withoutTrashed()
 * @mixin \Eloquent
 */
class NavigationPosition extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nav_position','permission'];

    protected $casts=['permission' => 'array'];

    protected $with = [
        'navigationItems'
    ];

    public function navigationItems() {
        return $this->hasMany(NavigationItem::class,'id_position')
                    ->whereNull('parent_id')
                    ->orderBy('order','ASC');
    }
}
